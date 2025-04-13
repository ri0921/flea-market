@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/index.css') }}">
@endsection

@section('content')
<div class="main">
    <div class="tabs">
        @if(request('keyword'))
            <a class="tab-suggest {{ $tab !== 'mylist' ? 'active' : '' }}" href="/search?tab=suggest&keyword={{ request('keyword') }}">おすすめ</a>
            <a class="tab-mylist {{ $tab === 'mylist' ? 'active' : '' }}" href="/search?tab=mylist&keyword={{ request('keyword') }}">マイリスト</a>
        @else
            <a class="tab-suggest {{ $tab !== 'mylist' ? 'active' : '' }}" href="/">おすすめ</a>
            <a class="tab-mylist {{ $tab === 'mylist' ? 'active' : '' }}" href="/?tab=mylist">マイリスト</a>
        @endif
    </div>
    <div class="tab-content">
        <ul class="list">
            @foreach ($items as $item)
            <li class="list-card">
                <a class="item-link" href="/item/{{ $item->id }}">
                    <img class="card__image" src="{{ Storage::url($item->image) }}" alt="商品画像" width="100%">
                    @if($item->is_sold)
                        <div class="sold-stamp">Sold</div>
                    @endif
                    <p class="card__title">{{ $item->name }}</p>
                </a>
            </li>
            @endforeach
        </ul>
    </div>
</div>
@endsection