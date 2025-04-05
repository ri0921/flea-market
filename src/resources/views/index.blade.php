@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/index.css') }}">
@endsection

@section('content')
<div class="main">
    <div class="tabs">
        <a class="tab-suggest {{ $tab !== 'mylist' ? 'active' : '' }}" href="/">おすすめ</a>
        <a class="tab-mylist {{ $tab === 'mylist' ? 'active' : '' }}" href="/?tab=mylist">マイリスト</a>
    </div>
    <div class="tab-content">
        <ul class="list">
            @foreach ($items as $item)
            <li class="list-card">
                <a href="/item/{{ $item->id }}">
                    <img src="{{ $item->image }}" alt="商品画像" width="100%">
                    <p class="image-title">{{ $item->name }}</p>
                </a>
            </li>
            @endforeach
        </ul>
    </div>
</div>
@endsection