<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Purchase;
use App\Models\Item;
use App\Models\Review;


class ReviewController extends Controller
{
    public function store(Request $request, Purchase $purchase)
    {
        $reviewer_id = auth()->user()->profile->id;

        $item = $purchase->item;
        if ($purchase->profile_id === $reviewer_id) {
            $reviewee_id = $item->profile_id;
        } else {
            $reviewee_id = $purchase->profile_id;
        }
        Review::create([
            'purchase_id' => $purchase->id,
            'reviewer_id' => $reviewer_id,
            'reviewee_id' => $reviewee_id,
            'rating' => $request->rating,
        ]);

        return redirect('/');
    }
}
