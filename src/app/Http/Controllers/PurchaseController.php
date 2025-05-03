<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\AddressRequest;
use App\Http\Requests\PurchaseRequest;
use App\Models\Item;
use App\Models\Address;
use App\Models\Purchase;
use Stripe\Stripe;
use Stripe\Checkout\Session;

class PurchaseController extends Controller
{
    public function purchase(Request $request, $id)
    {
        $item = Item::findOrFail($id);
        $user = Auth::user();
        $profile = $user->profile;
        $payment = session('payment_method');
        if ($request->has('payment_method')) {
            $payment = $request->input('payment_method');
            session(['payment_method' => $payment]);
        }
        if (!session()->has('address')) {
            session([
                'address' => [
                    'post_code' => $profile->post_code,
                    'address' => $profile->address,
                    'building' => $profile->building,
                ]
            ]);
        }
        $address = session('address');
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
        return redirect("/purchase/{$item->id}");
    }

    public function store(PurchaseRequest $request, $id)
    {
        $user = Auth::user();
        $item = Item::findOrFail($id);
        $profile = $user->profile;
        $addressData = session('address');
        $addressData['profile_id'] = $profile->id;
        $address = Address::create($addressData);

        $purchaseData = [
            'profile_id' => $profile->id,
            'item_id' => $item->id,
            'address_id' => $address->id,
            'payment_method' => session('payment_method'),
        ];
        Purchase::create($purchaseData);

        Stripe::setApiKey(config('services.stripe.secret'));
        $session = Session::create([
            'payment_method_types' => ['card', 'konbini'],
            'line_items' => [[
                'price_data' => [
                    'currency' => 'jpy',
                    'unit_amount' => intval($item->price),
                    'product_data' => [
                        'name' => $item->name,
                    ],
                ],
                'quantity' => 1,
            ]],
            'mode' => 'payment',
            'customer_email' => $user->email,
            'success_url' => route('checkout.success'),
            'cancel_url' => route('checkout.cancel'),
        ]);
        return redirect($session->url);
    }
}