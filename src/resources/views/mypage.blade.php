@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/mypage.css') }}">
@endsection

@section('content')
<div class="main">
    <div class="profile">
        <div class="user-image">
            <img class="rounded-circle" src="{{ $profile->image ? Storage::url($profile->image) : asset('img/default.png') }}" alt="プロフィール画像">
        </div>
        <div class="user-name">{{ $profile->name }}</div>
        <div class="profile-link">
            <button class="profile-link__button" type="button" onclick="location.href='/mypage/profile'">プロフィールを編集</button>
        </div>
    </div>
    <div class="tabs">
        <a class="tab-button" href="">出品した商品</a>
        <a class="tab-button" href="">購入した商品</a>
    </div>
    <div class="tab-content">
        <ul class="list">
            <li class="list-card">
                <img src="{{ asset('test-image.png') }}" alt="商品画像" width="100%">
                <p class="image-title">商品名</p>
            </li>
            <li class="list-card">
                <img src="{{ asset('test-image.png') }}" alt="商品画像">
                <p class="image-title">商品名</p>
            </li>
            <li class="list-card">
                <img src="{{ asset('test-image.png') }}" alt="商品画像">
                <p class="image-title">商品名</p>
            </li>
            <li class="list-card">
                <img src="{{ asset('test-image.png') }}" alt="商品画像">
                <p class="image-title">商品名</p>
            </li>
            <li class="list-card">
                <img src="{{ asset('test-image.png') }}" alt="商品画像">
                <p class="image-title">商品名</p>
            </li>
        </ul>
    </div>
</div>
@endsection