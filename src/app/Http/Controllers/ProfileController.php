<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Profile;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\ProfileRequest;

class ProfileController extends Controller
{
    public function index()
    {
        return view('profile');
    }

    public function store(ProfileRequest $request)
    {
        $user = Auth::user();
        $profile = Profile::create([
            'user_id' => $user->id,
            'name' => $request->input('name'),
            'post_code' => $request->input('post_code'),
            'address' => $request->input('address'),
            'building' => $request->input('building'),
        ]);

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
