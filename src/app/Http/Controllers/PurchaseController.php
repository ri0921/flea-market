<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PurchaseController extends Controller
{
    public function purchase()
    {
        return view('purchase');
    }

    public function edit()
    {
        return view('address');
    }
}
