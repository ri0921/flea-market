@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/chat.css') }}">
@endsection

@section('content')
<div class="container">
    <div class="sidebar">
        <p class="others-chat">その他の取引</p>
        <ul class="chat-menu">
            @foreach ($chatItems as $purchase)
            <li class="chat-list">
                <a class="chat-link" href="/mypage/chat/{{ $purchase->item->id }}">
                    {{ $purchase->item->name }}
                </a>
            </li>
            @endforeach
        </ul>
    </div>
    <div class="main">
        <header class="main-header">
            <div class="image">
                <img class="partner-image" src="{{ asset('img/default.png') }}">
            </div>
            <h2 class="title">「ユーザー名」さんとの取引画面</h2>
            <div class="button">
                <button class="completed-button">取引を完了する</button>
            </div>
        </header>
        <section class="item-info">
            <img class="item-image" src="{{ Storage::url($item->image) }}" alt="商品画像" width="100%">
            <div class="item-detail">
                <h3 class="item-name">{{ $item->name }}</h3>
                <p class="item-price">¥{{ number_format($item->price) }}</p>
            </div>
        </section>
        <section class="chat-area">
            <div class="chat-message other">
                <div class="user">
                    <div class="user-icon">
                        <img class="icon-image" src="{{ asset('img/default.png') }}">
                    </div>
                    <div class="user-name">ユーザー名</div>
                </div>
                <div class="message">
                    相手のメッセージ
                </div>
            </div>
            <div class="chat-message self">
                <div class="user">
                    <div class="user-icon">
                        <img class="icon-image" src="{{ asset('img/default.png') }}">
                    </div>
                    <div class="user-name">ユーザー名</div>
                </div>
                <div class="message">
                    自分のメッセージ
                </div>
                <div class="chat-actions">
                    <div class="edit">編集</div>
                    <div class="delete">削除</div>
                </div>
            </div>
        </section>
        <form action="" class="message-form">
            <input class="message-text" type="text" placeholder="取引メッセージを記入してください">
            <button class="add-image" type="button">画像を追加</button>
            <button class="send-message" type="submit">
                <img class="send-icon" src="{{ asset('send.jpg') }}" alt="送信">
            </button>
        </form>
    </div>
</div>
@endsection