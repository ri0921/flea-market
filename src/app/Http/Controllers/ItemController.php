<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\CommentRequest;
use App\Http\Requests\ExhibitionRequest;
use App\Models\Item;
use App\Models\Like;
use App\Models\Comment;
use App\Models\Profile;
use App\Models\Category;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ItemController extends Controller
{
    public function index()
    {
        $tab = request('tab');
        $user = Auth::user();
        if ($tab !== 'mylist') {
            if ($user && $user->profile) {
                $items = Item::where('profile_id', '!=', $user->profile->id)->latest()->get();
            } else {
                $items = Item::all();
            }
        } else {
            $items = $user && $user->profile && $user->profile->likedItems ? $user->profile->likedItems->filter(function ($item) use ($user) {
                return $item->profile_id !== $user->profile->id;
            }) : collect();
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
        $keyword = $request->keyword;
        $tab = request('tab');
        $user = Auth::user();

        if ($tab === 'mylist') {
            $items = $user && $user->profile && $user->profile->likedItems ? $user->profile->likedItems->filter(function ($item) use ($keyword) {
                return stripos($item->name, $keyword) !== false;
            }) : collect();
        } else {
            if ($user && $user->profile) {
                $items = Item::where('profile_id', '!=', $user->profile->id)
                ->KeywordSearch($keyword)->latest()->get();
            } else {
                $items = Item::KeywordSearch($keyword)->latest()->get();
            }
        }
        return view('index', compact('items', 'tab', 'keyword'));
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
        $categories = Category::all();
        return view('exhibition', compact('categories'));
    }

    public function store(ExhibitionRequest $request)
    {
        $user = Auth::user();
        $exhibition = $request->all();
        $exhibition['profile_id'] = $user->profile->id;
        $exhibition['image'] = $request->file('image')->store('img', 'public');
        $item = Item::create($exhibition);
        $item->categories()->attach($request->input('categories'));
        return redirect('/mypage?tab=sell');
    }
}
