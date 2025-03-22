@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/address.css') }}">
@endsection

@section('content')
<div class="main">
    <h1 class="title">住所の変更</h1>
    <div class="form">
        <form action="" method="POST">
            @csrf
            <div class="form__group">
                <label class="form__label" for="post_code">郵便番号</label>
                <input class="form__input" type="text" name="post_code" value="{{ old('post_code') }}">
                <div class="form__error">
                    @error('post_code')
                    @enderror
                </div>
            </div>
            <div class="form__group">
                <label class="form__label" for="address">住所</label>
                <input class="form__input" type="text" name="address" value="{{ old('address') }}">
                <div class="form__error">
                    @error('address')
                    @enderror
                </div>
            </div>
            <div class="form__group">
                <label class="form__label" for="building">建物名</label>
                <input class="form__input" type="text" name="building" value="{{ old('building') }}">
                <div class="form__error">
                    @error('building')
                    @enderror
                </div>
            </div>
            <div class="form__button">
                <button class="form__button-submit" type="submit">更新する</button>
            </div>
        </form>
    </div>
</div>
@endsection
