@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/purchase.css') }}">
@endsection

@section('content')
<div class="main">
    <div class="order-details">
        <div class="order__group">
            <div class="item-image">
                <img src="{{ Storage::url($item->image) }}" alt="商品画像" width="100%">
            </div>
            <p class="item-name">{{ $item->name }}</p>
            <div class="item-price"><span>¥</span>{{ number_format($item->price) }}</div>
        </div>
        <div class="order__group">
            <p class="order__group-p">支払い方法</p>
            <form class="form__select" action="/purchase/{{ $item->id }}" method="get">
                @csrf
                <select class="payment-method" name="payment_method" onchange="submit(this.form)">
                    <option value="" {{ old('payment_method', session('payment_method')) == '' ? 'selected' : '' }}>選択してください</option>
                    <option value="コンビニ払い" {{ old('payment_method', session('payment_method')) == 'コンビニ払い' ? 'selected' : '' }}>コンビニ払い</option>
                    <option value="カード支払い" {{ old('payment_method', session('payment_method')) == 'カード支払い' ? 'selected' : '' }}>カード支払い</option>
                </select>
            </form>
        </div>
        <div class="order__group">
            <div class="group__row">
                <p class="order__group-p">配送先</p>
                <a href="/purchase/address/{{ $item->id }}">変更する</a>
                </div>
            <div class="destination">
                <div class="post_code">{{ $address['post_code'] }}</div>
                <div class="address">{{ $address['address'] }}</div>
                <div class="building">{{ $address['building'] }}</div>
            </div>
            <div class="form__error">
                @error('address')
                {{ $message }}
                @enderror
            </div>
        </div>
    </div>
    <div class="order-confirm">
        <form action="/purchase/{{$item->id}}" method="post">
            @csrf
            <input type="hidden" name="payment_method" value="{{ session('payment_method') }}">
            <input type="hidden" name="address_id" value="">
            <table>
                <tr>
                    <th>商品代金</th>
                    <td><span>¥</span>{{ number_format($item->price) }}</td>
                </tr>
                <tr>
                    <th>支払い方法</th>
                    <td>{{ session('payment_method') ?? '選択されていません' }}</td>
                </tr>
            </table>
            <div class="form__error">
                @error('payment_method')
                {{ $message }}
                @enderror
            </div>
            <button class="purchase-button" type="submit">購入する</button>
        </form>
    </div>
</div>
@endsection