@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/index.css') }}">
@endsection

@section('content')
<div class="main">
    <div class="tabs">
        <a class="tab-button" href="">おすすめ</a>
        <a class="tab-button" href="">マイリスト</a>
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