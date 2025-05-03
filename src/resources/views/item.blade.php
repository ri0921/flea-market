@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/item.css') }}">
@endsection

@section('content')
<div class="main">
    <div class="column">
        <div class="item-image">
            <img class="item-image__file" src="{{ Storage::url($item->image) }}" alt="商品画像" width="100%">
            @if($item->is_sold)
                <div class="sold-stamp">Sold</div>
            @endif
        </div>
    </div>
    <div class="column">
        <div class="content">
            <div class="item-name">
                {{ $item->name }}
            </div>
            <div class="brand">
                {{ $item->brand ?? 'unknown' }}
            </div>
            <div class="price">
                ¥<span class="price__span">{{ number_format($item->price) }}</span>(税込)
            </div>
            <div class="action">
                <div class="action__item">
                    <div class="action__icon">
                        @if(Auth::check() && $item->liked_by_profile())
                        <a href="/item/{{ $item->id }}/unlike">
                            <img class="action__icon-image" src="{{ asset('like.svg') }}" alt="いいね">
                        </a>
                        @else
                        <a href="/item/{{ $item->id }}/like">
                            <img class="action__icon-image" src="{{ asset('unlike.svg') }}" alt="いいね">
                        </a>
                        @endif
                    </div>
                    <div class="action__count">
                        {{ $item->likes->count() }}
                    </div>
                </div>
                <div class="action__item">
                    <div class="action__icon">
                        <img class="action__icon-image" src="{{ asset('comments.svg') }}" alt="コメント">
                    </div>
                    <div class="action__count">
                        {{ $item->comments->count() }}
                    </div>
                </div>
            </div>
            @if(!$item->is_sold)
                <button class="purchase__button" type="button" onclick="location.href='/purchase/{{ $item->id }}'">購入手続きへ</button>
            @else
                <button class="disabled__button" type="button" disabled>購入手続きへ</button>
            @endif

            <div class="content__group">
                <p class="group__title">商品説明</p>
                <div class="group__inner">
                    {{ $item->description }}
                </div>
            </div>
            <div class="content__group">
                <p class="group__title">商品の情報</p>
                <div class="group__inner">
                    <div class="information">
                        <div class="information__text">カテゴリー</div>
                        <ul class="information__category">
                            @foreach ($item->categories as $category)
                            <li class="information__category-content">{{ $category->content }}</li>
                            @endforeach
                        </ul>
                    </div>
                    <div class="information">
                        <div class="information__text">商品の状態</div>
                        <div class="condition">{{ $item->condition }}</div>
                    </div>
                </div>
            </div>
            <div class="content__group">
                <p class="group__title">コメント({{ $item->comments->count() }})</p>
                <div class="group__inner">
                    <div class="comments-list">
                        @foreach($comments as $comment)
                        <div class="comment__user">
                            <div class="user-image">
                                <img class="user-image__file" src="{{ $comment->profile->image ? Storage::url($comment->profile->image) : asset('img/default.png') }}" alt="プロフィール画像">
                            </div>
                            <div class="user-name">{{ $comment->profile->name }}</div>
                        </div>
                        <div class="comment__detail">
                            {{ $comment->detail }}
                        </div>
                        @endforeach
                    </div>
                    @if(!$item->is_sold)
                    <div class="comment__form">
                        <form action="/item/{{ $item->id }}" method="post">
                            @csrf
                            <label class="comment__label">商品へのコメント</label>
                            <textarea class="comment__textarea" name="detail"></textarea>
                            <div class="form__error">
                                @error('detail')
                                {{ $message }}
                                @enderror
                            </div>
                            <button class="comment__button" type="submit">コメントを送信する</button>
                        </form>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection