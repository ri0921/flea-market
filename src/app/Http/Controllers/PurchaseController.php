<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\AddressRequest;
use App\Models\Item;
use App\Models\Profile;
use App\Models\Address;

class PurchaseController extends Controller
{
    public function purchase(Request $request, $id)
    {
        $item = Item::findOrFail($id);
        $user = Auth::user();
        $profile = $user->profile;
        $payment = session('payment');
        if ($request->has('payment')) {
            $payment = $request->input('payment');
            session(['payment' => $payment]);
        }
        $address = session('address');
        if (!$address) {
            $address = [
                'post_code' => $profile->post_code,
                'address' => $profile->address,
                'building' => $profile->building,
            ];
        }
        return view('purchase', compact('item', 'profile', 'payment', 'address'));
    }

    public function edit($id)
    {
        $item = Item::findOrFail($id);
        return view('address', compact('item'));
    }

    public function update(AddressRequest $request, $id)
    {
        $item = Item::findOrFail($id);
        $user = Auth::user();
        $profile = $user->profile;
        $address = $request->only(['post_code', 'address', 'building']);
        session(['address' => $address]);
        return view('purchase', compact('item', 'profile', 'address'));
    }
}
