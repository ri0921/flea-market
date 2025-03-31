<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\CommentRequest;
use App\Models\Item;
use App\Models\Like;
use App\Models\Comment;
use App\Models\Profile;
use Illuminate\Support\Facades\Auth;

class ItemController extends Controller
{
    public function index()
    {
        $tab = request('tab');
        $user = Auth::user();
        if ($tab !== 'mylist') {
            $items = Item::all();
        } else {
            $items = $user ? $user->profile->likedItems : collect();
        }
        return view('index', compact('items', 'tab'));
    }

    public function show($id)
    {
        $item = Item::findOrFail($id);
        $comments = $item->comments()->with('profile')->get();
        $profiles = Profile::all();
        return view('item', compact('item', 'comments', 'profiles'));
    }

    public function search(Request $request)
    {
        $items = Item::KeywordSearch($request->keyword)->get();
        $tab = request('tab');
        return view('index', compact('items', 'tab'));
    }

    public function like($id)
    {
        $user = Auth::user();
        Like::create([
            'item_id' => $id,
            'profile_id' => $user->profile->id,
        ]);
        return redirect()->back();
    }

    public function unlike($id)
    {
        $user = Auth::user();
        $like = Like::where('item_id', $id)->where('profile_id', $user->profile->id)->first();
        $like->delete();
        return redirect()->back();
    }

    public function comment(CommentRequest $request, $id)
    {
        $user = Auth::user();
        Comment::create([
            'item_id' => $id,
            'profile_id' => $user->profile->id,
            'detail' => $request->detail,
        ]);
        return redirect()->back();
    }

    public function exhibit()
    {
        return view('exhibition');
    }
}
