@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/item.css') }}">
@endsection

@section('content')
<div class="main">
    <div class="column">
        <div class="item-image">
            <img src="{{ asset('test-image.png') }}" alt="商品画像" width="100%">
        </div>
    </div>
    <div class="column">
        <div class="content">
            <div class="item-name">
                商品名
            </div>
            <div class="brand">
                ブランド名
            </div>
            <div class="price">
                ¥<span>47,000</span>(税込)
            </div>
            <div class="action">
                <div class="action__item">
                    <div class="action__icon">
                        <img src="{{ asset('likes.png') }}" alt="いいね">
                    </div>
                    <div class="action__count">
                        3
                    </div>
                </div>
                <div class="action__item">
                    <div class="action__icon">
                        <img src="{{ asset('comments.png') }}" alt="コメント">
                    </div>
                    <div class="action__count">
                        1
                    </div>
                </div>
            </div>
            <button class="purchase__button" type="button" onclick="location.href='/purchase'">購入手続きへ</button>

            <div class="content__group">
                <p class="group__title">商品説明</p>
                <div class="group__inner">
                商品の状態は良好です。傷もありません。<br>購入後、即発送します。
                </div>
            </div>
            <div class="content__group">
                <p class="group__title">商品の情報</p>
                <div class="group__inner">
                    <div class="info">
                        <div class="info__text">カテゴリー</div>
                        <ul>
                            <li>洋服</li>
                            <li>ファッション</li>
                            <li>本</li>
                            <li>あああ</li>
                            <li>ああああ</li>
                        </ul>
                    </div>
                    <div class="info">
                        <div class="info__text">商品の状態</div>
                        <div class="condition">良好</div>
                    </div>
                </div>
            </div>
            <div class="content__group">
                <p class="group__title">コメント(1)</p>
                <div class="group__inner">
                    <div class="comments-list">
                        <div class="comment__user">
                            <div class="user-image">
                                <img src="{{ asset('img/default.png') }}" alt="プロフィール画像">
                            </div>
                            <div class="user-name">admin</div>
                        </div>
                        <div class="comment__detail">
                            こちらにコメントが入ります。
                        </div>
                    </div>
                    <div class="comment__form">
                        <form action="" method="post">
                            @csrf
                            <label class="comment__label">商品へのコメント</label>
                            <textarea class="comment__textarea" name="detail"></textarea>
                            <button class="comment__button" type="submit">コメントを送信する</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection