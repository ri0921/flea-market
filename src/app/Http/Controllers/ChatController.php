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
    public function chat(Request $request, Purchase $purchase)
    {
        $item = $purchase->item;
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
            ->withMax('chats', 'created_at')
            ->orderByDesc('chats_max_created_at')
            ->get();

        $profile = Auth::user()->profile;
        $chats = Chat::where('purchase_id', $purchase->id)
            ->orderBy('created_at', 'asc')
            ->get();

        if ($purchase->profile->id === $profileId) {
            $partner = $item->profile;
        } else {
            $partner = $purchase->profile;
        }

        if ($request->has('draft') && $request->has('from_purchase_id')) {
            session(['chat_draft_purchase_'. $request->from_purchase_id => $request->draft]);
        }

        $draft = session('chat_draft_purchase_'. $purchase->id, '');

        Chat::where('purchase_id', $purchase->id)
            ->whereNull('read_at')
            ->where('sender_id', '!=', $profileId)
            ->update(['read_at' => now()]);

        $isCompleted = $purchase->completed_at ?? false;

        return view('chat', compact('item', 'chatItems', 'chats', 'profileId', 'partner', 'profile', 'draft', 'purchase', 'isCompleted'));
    }

    public function send(ChatRequest $request, Purchase $purchase)
    {
        $item = $purchase->item;
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
        return redirect('/mypage/chat/' . $purchase->id);
    }

    public function edit(ChatRequest $request, Chat $chat)
    {
        $chat->message = $request->message;
        $chat->save();

        return redirect()->back();
    }

    public function destroy(Chat $chat)
    {
        $chat->delete();

        return redirect()->back();
    }

    public function complete(Request $request, Purchase $purchase)
    {
        $purchase->completed_at = now();
        $purchase->save();

        return redirect('/mypage/chat/'. $purchase->id);
    }
}
