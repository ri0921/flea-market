@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/register.css') }}">
@endsection

@section('content')
<div class="main">
    <h1 class="title">会員登録</h1>
    <div class="form">
        <form action="/register" method="POST">
            @csrf
            <div class="form__group">
                <label class="form__label" for="name">ユーザー名</label>
                <input class="form__input" type="text" name="name" value="{{ old('name') }}">
                <div class="form__error">
                    @error('name')
                    @enderror
                </div>
            </div>
            <div class="form__group">
                <label class="form__label" for="email">メールアドレス</label>
                <input class="form__input" type="email" name="email" value="{{ old('email') }}">
                <div class="form__error">
                    @error('email')
                    @enderror
                </div>
            </div>
            <div class="form__group">
                <label class="form__label" for="password">パスワード</label>
                <input class="form__input" type="password" name="password" value="{{ old('password') }}">
                <div class="form__error">
                    @error('password')
                    @enderror
                </div>
            </div>
            <div class="form__group">
                <label class="form__label" for="password_confirm">確認用パスワード</label>
                <input class="form__input" type="password" name="password_confirm" value="{{ old('password_confirm') }}">
                <div class="form__error">
                    @error('password_confirm')
                    @enderror
                </div>
            </div>
            <div class="form__button">
                <button class="form__button-submit" type="submit">登録する</button>
            </div>
            <div class="login__link">
                <a href="/login">ログインはこちら</a>
            </div>
        </form>
    </div>
</div>
@endsection
