@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/index.css') }}">
@endsection

@section('content')
<div class="main">
    <div class="tabs">
        <a class="tab-suggest" href="/">おすすめ</a>
        <a class="tab-mylist" href="">マイリスト</a>
    </div>
    <div class="tab-content">
        <ul class="list">
            @foreach ($items as $item)
            <li class="list-card">
                <a href="/item">
                    <img src="{{ $item['image'] }}" alt="商品画像" width="100%">
                    <p class="image-title">{{ $item['name'] }}</p>
                </a>
            </li>
            @endforeach
        </ul>
    </div>
</div>
@endsection