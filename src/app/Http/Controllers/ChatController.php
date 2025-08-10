<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Item;

class ChatController extends Controller
{
    public function chat($id)
    {
        $item = Item::findOrFail($id);
        return view('chat', compact('item'));
    }
}
