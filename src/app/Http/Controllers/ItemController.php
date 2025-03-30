<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Item;
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

    public function exhibit()
    {
        return view('exhibition');
    }
}
