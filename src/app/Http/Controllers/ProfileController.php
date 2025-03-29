<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function index()
    {
        return view('profile');
    }

    public function setup(Request $request)
    {
        $user = Auth::user();
        
        $user->name = $request->input('name');
        $user->image = $request->input('image');
        $user->post_code = $request->input('post_code');
        $user->address = $request->input('address');
        $user->building = $request->input('building');

        $form = $request->all();
        Profile::create($form);
        return redirect('/');
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
