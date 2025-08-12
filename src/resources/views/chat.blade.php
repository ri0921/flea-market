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
                <a class="chat-link" href="/mypage/chat/{{ $purchase->id }}">
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
            @if($profileId === $purchase->profile_id)
                <form class="complete-form" action="/mypage/chat/{{ $purchase->id }}/complete" method="post">
                    @csrf
                    <button class="complete-button" id="openModalBtn">取引を完了する</button>
                </form>
            @endif
            <!-- モーダル -->
            @if($purchase->completed_at)
            <div class="modal">
                <div class="modal-content">
                    <p class="completed-message">取引が完了しました。</p>
                    <p class="rating-message">今回の取引相手はどうでしたか？</p>
                    <div class="stars">
                        @for ($i = 1; $i <= 5; $i++)
                            <span class="star" data-value="{{ $i }}">&#9733;</span>
                        @endfor
                    </div>
                    <form class="rating-form" action="/mypage/chat/{{ $purchase->id }}/review" method="POST">
                        @csrf
                        <input type="hidden" name="rating" id="ratingValue">
                        <button type="submit" class="send-rating">送信する</button>
                    </form>
                </div>
            </div>
            @endif
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
                    <div class="message" id="message-text-{{ $chat->id }}">
                        {{ $chat->message }}
                    </div>
                    <form method="POST" action="/mypage/chat/{{ $chat->id }}" class="edit-form" id="edit-form-{{ $chat->id }}" style="display:none;">
                        @csrf
                        @method('PUT')
                        <input type="text" name="message" value="{{ $chat->message }}">
                        <button type="submit">保存</button>
                        <button type="button" class="cancel-edit" data-id="{{ $chat->id }}">キャンセル</button>
                    </form>
                    <div class="chat-actions">
                        <button class="edit" type="button" data-id="{{ $chat->id }}">編集</button>
                        <form class="delete-form" method="POST" action="/mypage/chat/{{ $chat->id }}" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button class="delete" type="submit" onclick="return confirm('本当に削除しますか？')">削除</button>
                        </form>
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
        <form action="/mypage/chat/{{ $purchase->id }}" method="POST" enctype="multipart/form-data" class="message-form">
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
    // 画像プレビュー
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

    // メッセージの保持
    const currentItemId = @json($purchase->id);
    document.querySelectorAll('.chat-link').forEach(link => {
        link.addEventListener('click', function(event) {
            event.preventDefault();
            const messageTextarea = document.querySelector('textarea[name="message"]');
            const draftText = encodeURIComponent(messageTextarea ? messageTextarea.value : '');

            const url = new URL(this.href, window.location.origin);
            url.searchParams.set('draft', draftText);
            url.searchParams.set('from_purchase_id', currentItemId);
            window.location.href = url.toString();
        });
    });

    // メッセージ編集フォーム
    document.querySelectorAll('.edit').forEach(button => {
        button.addEventListener('click', e => {
            const id = e.target.dataset.id;
            document.getElementById(`message-text-${id}`).style.display = 'none';
            document.getElementById(`edit-form-${id}`).style.display = 'inline-block';
        });
    });

    document.querySelectorAll('.cancel-edit').forEach(button => {
        button.addEventListener('click', e => {
            const id = e.target.dataset.id;
            document.getElementById(`message-text-${id}`).style.display = 'inline';
            document.getElementById(`edit-form-${id}`).style.display = 'none';
        });
    });

    // モーダル
    document.querySelectorAll('.star').forEach(star => {
        star.addEventListener('click', function() {
            let value = this.getAttribute('data-value');
            document.getElementById('ratingValue').value = value;

            document.querySelectorAll('.star').forEach(s => {
                s.classList.remove('selected');
                if (s.getAttribute('data-value') <= value) {
                    s.classList.add('selected');
                }
            });
        });
    });
</script>
@endsection