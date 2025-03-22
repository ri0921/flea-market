@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/exhibition.css') }}">
@endsection

@section('content')
<div class="main">
    <h1 class="title">商品の出品</h1>
    <div class="form">
        <form action="" method="POST">
            @csrf
            <h2 class="form__title">商品の詳細</h2>
            <div class="form__group">
                <p class="form__content">商品画像</p>
                <div class="form__image">
                    <input class="upload__image" type="file" accept="image/*" name="image" id="file-input">
                    <label class="upload__button" for="file-input">画像を選択する</label>
                </div>
                <div class="form__error">
                    @error('image')
                    {{ $message }}
                    @enderror
                </div>
            </div>
            <div class="form__group">
                <p class="form__content">カテゴリー</p>
                <div class="form__checkbox">
                    <label class="checkbox-item"><input type="checkbox" name="category_id" value=""><span>ファッション</span></label>
                    <label class="checkbox-item"><input type="checkbox" name="category_id"><span>家電</span></label>
                    <label class="checkbox-item"><input type="checkbox" name="category_id"><span>インテリア</span></label>
                    <label class="checkbox-item"><input type="checkbox" name="category_id"><span>レディース</span></label>
                    <label class="checkbox-item"><input type="checkbox" name="category_id"><span>メンズ</span></label>
                    <label class="checkbox-item"><input type="checkbox" name="category_id"><span>コスメ</span></label>
                    <label class="checkbox-item"><input type="checkbox" name="category_id"><span>本</span></label>
                    <label class="checkbox-item"><input type="checkbox" name="category_id"><span>ゲーム</span></label>
                    <label class="checkbox-item"><input type="checkbox" name="category_id"><span>スポーツ</span></label>
                </div>
                <div class="form__error">
                    @error('category_id')
                    {{ $message }}
                    @enderror
                </div>
            </div>
            <div class="form__group">
                <p class="form__content">商品の状態</p>
                <div class="form__select">
                    <select name="condition_id">
                        <option value="" selected>選択してください</option>
                    </select>
                </div>
                <div class="form__error">
                    @error('condition_id')
                    {{ $message }}
                    @enderror
                </div>
            </div>
            <h2 class="form__title">商品名と説明</h2>
            <div class="form__group">
                <p class="form__content">商品名</p>
                <input class="form__input" type="text" name="name" value="{{ old('name') }}">
                <div class="form__error">
                    @error('name')
                    @enderror
                </div>
            </div>
            <div class="form__group">
                <p class="form__content">ブランド名</p>
                <input class="form__input" type="text" name="brand" value="{{ old('brand') }}">
            </div>
            <div class="form__group">
                <p class="form__content">商品の説明</p>
                <textarea class="form__textarea" name="description" value="{{ old('description') }}"></textarea>
                <div class="form__error">
                    @error('description')
                    @enderror
                </div>
            </div>
            <div class="form__group">
                <p class="form__content">販売価格</p>
                <div class="input-wrapper">
                    <span class="currency-symbol">¥</span>
                    <input class="form__input-hidden" type="text" name="price" value="{{ old('price') }}">
                </div>
                <div class="form__error">
                    @error('price')
                    @enderror
                </div>
            </div>
            <div class="form__button">
                <button class="form__button-submit" type="submit">出品する</button>
            </div>
        </form>
    </div>
</div>
@endsection
