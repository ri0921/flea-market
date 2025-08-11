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
                <img class="partner-image" src="{{ $partner->image ? Storage::url($partner->image) : asset('img/default.png') }}" alt="アイコン">
            </div>
            <h2 class="title">「{{ $partner->name }}」さんとの取引画面</h2>
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
            @foreach($chats as $chat)
                @if($chat->sender_id === $profileId)
                <div class="chat-message self">
                    <div class="user">
                        <div class="user-icon">
                            <img class="icon-image" src="{{ $profile->image ? Storage::url($profile->image) : asset('img/default.png') }}" alt="アイコン">
                        </div>
                        <div class="user-name">{{ $profile->name }}</div>
                    </div>
                    @if($chat->message_image)
                        <div class="send-image">
                            <img class="send-image__path" src="{{ asset('storage/' . $chat->message_image) }}" alt="送信画像">
                        </div>
                    @endif
                    <div class="message">
                        {{ $chat->message }}
                    </div>
                    <div class="chat-actions">
                        <div class="edit">編集</div>
                        <div class="delete">削除</div>
                    </div>
                </div>
                @else
                <div class="chat-message other">
                    <div class="user">
                        <div class="user-icon">
                            <img class="icon-image" src="{{ $partner->image ? Storage::url($partner->image) : asset('img/default.png') }}" alt="アイコン">
                        </div>
                        <div class="user-name">{{ $partner->name }}</div>
                    </div>
                    @if($chat->message_image)
                        <div class="send-image">
                            <img class="send-image__path" src="{{ asset('storage/' . $chat->message_image) }}" alt="送信画像">
                        </div>
                    @endif
                    <div class="message">
                        {{ $chat->message }}
                    </div>
                </div>
                @endif
            @endforeach
        </section>
        <img class="message-image" id="add-image">
        @if ($errors->any())
            <div class="form-error">
                @foreach ($errors->all() as $error)
                    <p>{{ $error }}</p>
                @endforeach
            </div>
        @endif
        <form action="/mypage/chat/{{$item->id}}" method="POST" enctype="multipart/form-data" class="message-form">
            @csrf
            <textarea class="message-text" type="text" name="message" placeholder="取引メッセージを記入してください">{{ urldecode($draft ?? '') }}</textarea>
            <input class="add-image" type="file" accept="image/*" name="message_image" id="file-input">
            <label class="upload__button" for="file-input">画像を追加</label>
            <button class="send-message" type="submit">
                <img class="send-icon" src="{{ asset('send.jpg') }}" alt="送信">
            </button>
        </form>
    </div>
</div>

<script>
    const fileInput = document.getElementById('file-input');
    const imagePreview = document.getElementById('add-image');

    fileInput.addEventListener('change', function(event) {
        const file = event.target.files[0];
        if (file && file.type.startsWith('image/')) {
            const reader = new FileReader();
            reader.onload = function(e) {
                imagePreview.src = e.target.result;
                imagePreview.style.display = 'block';
            };
            reader.readAsDataURL(file);
        }
    });

    const currentItemId = @json($item->id);
    document.querySelectorAll('.chat-link').forEach(link => {
        link.addEventListener('click', function(event) {
            event.preventDefault();
            const messageTextarea = document.querySelector('textarea[name="message"]');
            const draftText = encodeURIComponent(messageTextarea ? messageTextarea.value : '');

            const url = new URL(this.href, window.location.origin);
            url.searchParams.set('draft', draftText);
            url.searchParams.set('from_item_id', currentItemId);
            window.location.href = url.toString();
        });
    });
</script>
@endsection