<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Profile;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\ProfileRequest;
use Illuminate\Support\Facades\Storage;

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
                $data['image'] = $request->file('image')->store('profile_img', 'public');
            }
            Profile::find($profile->id)->update($data);
            return redirect('/mypage');
        } else {
            if ($request->hasFile('image')) {
                $data['image'] = $request->file('image')->store('profile_img', 'public');
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
        return view('mypage', compact('profile', 'tab', 'sellItems', 'buyItems'));
    }
}