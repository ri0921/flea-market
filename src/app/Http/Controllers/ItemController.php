<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Item;
use App\Models\Like;
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
        return view('item', compact('item'));
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

    public function exhibit()
    {
        return view('exhibition');
    }
}
