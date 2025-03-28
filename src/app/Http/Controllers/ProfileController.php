<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function index()
    {
        return view('profile');
    }

    public function create(Request $request)
    {
        
    }

    public function mypage()
    {
        return view('mypage');
    }

    public function edit()
    {
        return view('profile');
    }
}
