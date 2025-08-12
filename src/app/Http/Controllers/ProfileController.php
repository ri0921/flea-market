<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Profile;
use App\Models\Purchase;
use App\Models\Chat;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\ProfileRequest;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

class ProfileController extends Controller
{
    public function edit()
    {
        $user = Auth::user();
        $profile = $user->profile;
        return view('profile', compact('profile'));
    }

    public function update(ProfileRequest $request)
    {
        $user = Auth::user();
        $profile = $user->profile;
        $data = $request->all();
        if ($user->profile) {
            if ($request->hasFile('image')) {
                if ($profile->image && Storage::exists('public/'. $profile->image)) {
                Storage::delete('public/'. $profile->image);
                }
                $data['image'] = $request->file('image')->store('img', 'public');
            }
            Profile::find($profile->id)->update($data);
            return redirect('/mypage');
        } else {
            if ($request->hasFile('image')) {
                $data['image'] = $request->file('image')->store('img', 'public');
            }
            $data['user_id'] = $user->id;
            Profile::create($data);
            return redirect('/?tab=mylist');
        }
    }

    public function mypage()
    {
        $user = Auth::user();
        $profile = $user->profile;
        $tab = request('tab', 'sell');
        $sellItems = $profile->items()->with('purchase')->latest()->get();
        $buyItems = $profile->purchases()->with('item')->latest()->get();

        $profileId = $profile->id;
        $chatItems = Purchase::where(function ($query) use ($profileId) {
            $query->whereHas('item', function ($q) use ($profileId) {
                $q->where('profile_id', $profileId);
            })
                ->orWhere('profile_id', $profileId);
        })
            ->whereDoesntHave('reviewsWritten', function ($q) use ($profileId) {
                $q->where('reviewer_id', $profileId);
            })
            ->with(['item', 'reviewsWritten'])
            ->withMax('chats', 'created_at')
            ->orderByDesc('chats_max_created_at')
            ->get();

        $chatItemIds = $chatItems->pluck('id');
        $unreadCounts = \DB::table('chats')
            ->select('purchase_id', \DB::raw('count(*) as unread_count'))
            ->whereIn('purchase_id', $chatItemIds)
            ->whereNull('read_at')
            ->where('sender_id', '!=', $profileId)
            ->groupBy('purchase_id')
            ->pluck('unread_count', 'purchase_id');

        $totalUnread = $unreadCounts->sum();

        return view('mypage', compact('profile', 'tab', 'sellItems', 'buyItems', 'chatItems', 'unreadCounts', 'totalUnread'));
    }
}