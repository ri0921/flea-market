@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/purchase.css') }}">
@endsection

@section('content')
<div class="main">
    <form class="order__form" action="" method="post">
    @csrf
        <div class="order-details">
            <div class="order__group">
                <div class="item-image">
                    <img src="{{ asset('test-image.png') }}" alt="商品画像" width="100%">
                </div>
                <p class="item-name">商品名</p>
                <div class="item-price"><span>¥</span>47,000</div>
            </div>
            <div class="order__group">
                <p class="order__group-p">支払い方法</p>
                <div class="form__select">
                    <select class="payment-method" name="payment">
                        <option value="" selected>選択してください</option>
                        <option value="コンビニ払い">コンビニ払い</option>
                        <option value="カード支払い">カード支払い</option>
                    </select>
                </div>
            </div>
            <div class="order__group">
                <div class="group__row">
                    <p class="order__group-p">配送先</p>
                    <a href="">変更する</a>
                </div>
                <div class="destination">
                    <div class="post_code">〒XXX-YYYY</div>
                    <div class="address">ここには住所と</div>
                    <div class="building">建物が入ります。</div>
                </div>
            </div>
        </div>
        <div class="order-confirm">
            <table>
                <tr>
                    <th>商品代金</th>
                    <td><span>¥</span>47,000</td>
                </tr>
                <tr>
                    <th>支払い方法</th>
                    <td>コンビニ払い</td>
                </tr>
            </table>
            <button class="purchase-button" type="submit">購入する</button>
        </div>
    </form>
</div>
@endsection