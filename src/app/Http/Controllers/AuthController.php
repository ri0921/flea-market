<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use App\Http\Requests\RegisterRequest;
use App\Actions\Fortify\CreateNewUser;

class RegisterController extends Controller
{
    protected $createNewUser;

    public function __construct(CreateNewUser $createNewUser)
    {
        $this->createNewUser = $createNewUser;
    }

    /**
     * 新しいユーザーを登録する
     *
     * @param  RegisterRequest  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function register(RegisterRequest $request)
    {
        // CreateNewUserサービスを使用してユーザーを作成
        $user = $this->createNewUser->create($request);

        // ユーザー登録後の処理（ログインなど）
        auth()->login($user);

        // ホームにリダイレクト
        return view('profile');
    }
}