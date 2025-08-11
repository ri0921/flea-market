<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Item;
use App\Models\Purchase;
use Illuminate\Support\Facades\Auth;

class ChatController extends Controller
{
    public function chat($id)
    {
        $item = Item::findOrFail($id);
        $profileId = Auth::user()->profile->id;
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
        ->latest()->get();

        return view('chat', compact('item', 'chatItems'));
    }
}
