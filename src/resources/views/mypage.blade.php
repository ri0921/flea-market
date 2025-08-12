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
        <div class="user-info">
            <div class="user-name">
                {{ $profile->name }}
            </div>
            @if (!is_null($averageRating))
            <div class="user-rating">
                @for ($i = 1; $i <= 5; $i++)
                    @if ($i <= $averageRating)
                        <span class="star filled">&#9733;</span>
                    @else
                        <span class="star">&#9733;</span>
                    @endif
                @endfor
            </div>
            @endif
        </div>
        <div class="profile-link">
            <button class="profile-link__button" type="button" onclick="location.href='/mypage/profile'">プロフィールを編集</button>
        </div>
    </div>
    <div class="tabs">
        <a class="tab-button {{ $tab === 'sell' ? 'active' : '' }}" href="/mypage?tab=sell">出品した商品</a>
        <a class="tab-button {{ $tab === 'buy' ? 'active' : '' }}" href="/mypage?tab=buy">購入した商品</a>
        <a class="tab-button {{ $tab === 'chat' ? 'active' : '' }}" href="/mypage?tab=chat">取引中の商品
            @if($totalUnread > 0)
                <span class="total-unread-badge">{{ $totalUnread }}</span>
            @endif
        </a>
    </div>
    <div class="tab-content">
        @if ($tab === 'sell' && $sellItems->isNotEmpty())
        <ul class="list">
            @foreach ($sellItems as $item)
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
        @elseif ($tab === 'buy' && $buyItems->isNotEmpty())
        <ul class="list">
            @foreach ($buyItems as $purchase)
            <li class="list-card">
                <a class="item-link" href="/item/{{ $purchase->item->id }}">
                    <img class="card__image" src="{{ Storage::url($purchase->item->image) }}" alt="商品画像" width="100%">
                    <div class="sold-stamp">Sold</div>
                    <p class="card__title">{{ $purchase->item->name }}</p>
                </a>
            </li>
            @endforeach
        </ul>
        @elseif ($tab === 'chat' && $chatItems->isNotEmpty())
        <ul class="list">
            @foreach ($chatItems as $purchase)
            <li class="list-card">
                <a class="item-link" href="/mypage/chat/{{ $purchase->id }}">
                    <img class="card__image" src="{{ Storage::url($purchase->item->image) }}" alt="商品画像" width="100%">
                    @if(isset($unreadCounts[$purchase->id]) && $unreadCounts[$purchase->id] > 0)
                        <div class="unread-badge">
                            {{ $unreadCounts[$purchase->id] }}
                        </div>
                    @endif
                    <p class="card__title">{{ $purchase->item->name }}</p>
                </a>
            </li>
            @endforeach
        </ul>
        @endif
    </div>
</div>
@endsection