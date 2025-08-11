<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\ChatRequest;
use App\Models\Item;
use App\Models\Purchase;
use App\Models\Chat;
use Illuminate\Support\Facades\Auth;

class ChatController extends Controller
{
    public function chat(Request $request, $id)
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

        $profile = Auth::user()->profile;
        $purchase = Purchase::where('item_id', $item->id)->firstOrFail();
        $chats = Chat::where('purchase_id', $purchase->id)
            ->orderBy('created_at', 'asc')
            ->get();

        if ($purchase->profile->id === $profileId) {
            $partner = $item->profile;
        } else {
            $partner = $purchase->profile;
        }

        if ($request->has('draft') && $request->has('from_item_id')) {
            session(['chat_draft_item_'. $request->from_item_id => $request->draft]);
        }

        $draft = session('chat_draft_item_'. $item->id, '');

        return view('chat', compact('item', 'chatItems', 'chats', 'profileId', 'partner', 'profile', 'draft'));
    }

    public function send(ChatRequest $request, $id)
    {
        $item = Item::findOrFail($id);
        $purchase = Purchase::where('item_id', $item->id)->firstOrFail();
        $profile = Auth::user()->profile;

        $data = [
            'purchase_id' => $purchase->id,
            'sender_id' => $profile->id,
            'receiver_id' => $item->profile->id,
            'message' => $request->input('message'),
        ];
        if ($request->hasFile('message_image')) {
            $data['message_image'] = $request->file('message_image')->store('img', 'public');
        }
        Chat::create($data);
        return redirect('/mypage/chat/' . $item->id);
    }
}
