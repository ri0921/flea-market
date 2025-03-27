<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ItemController extends Controller
{
    public function index()
    {
        return view('index');
    }

    public function exhibit()
    {
        return view('exhibition');
    }

    public function show()
    {
        return view('item');
    }
}
