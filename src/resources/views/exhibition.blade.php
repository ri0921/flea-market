@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/exhibition.css') }}">
@endsection

@section('content')
<div class="main">
    <h1 class="title">商品の出品</h1>
    <div class="form">
        <form action="/sell" method="POST" enctype="multipart/form-data">
            @csrf
            <h2 class="form__title">商品の詳細</h2>
            <div class="form__group">
                <p class="form__content">商品画像</p>
                <div class="form__image">
                    <input class="upload__image" type="file" accept="image/*" name="image" id="file-input">
                    <label class="upload__button" for="file-input">画像を選択する</label>
                    <img class="item-image" id="image-preview" style="display: none;">
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
                    @foreach($categories as $category)
                    <label class="checkbox-item"><input class="checkbox-item__input" type="checkbox" name="categories[]" value="{{ $category->id }}" {{ in_array($category->id, old('categories', [])) ? 'checked' : '' }}><span class="checkbox-item__span">{{ $category->content }}</span></label>
                    @endforeach
                </div>
                <div class="form__error">
                    @error('categories')
                    {{ $message }}
                    @enderror
                </div>
            </div>
            <div class="form__group">
                <p class="form__content">商品の状態</p>
                <div class="form__select">
                    <select class="form__select-condition" name="condition">
                        <option value="" hidden selected>選択してください</option>
                        <option value="良好" {{ old('condition') == '良好' ? 'selected' : '' }}>良好</option>
                        <option value="目立った傷や汚れなし" {{ old('condition') == '目立った傷や汚れなし' ? 'selected' : '' }}>目立った傷や汚れなし</option>
                        <option value="やや傷や汚れあり" {{ old('condition') == 'やや傷や汚れあり' ? 'selected' : '' }}>やや傷や汚れあり</option>
                        <option value="状態が悪い" {{ old('condition') == '状態が悪い' ? 'selected' : '' }}>状態が悪い</option>
                    </select>
                </div>
                <div class="form__error">
                    @error('condition')
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
                    {{ $message }}
                    @enderror
                </div>
            </div>
            <div class="form__group">
                <p class="form__content">ブランド名</p>
                <input class="form__input" type="text" name="brand" value="{{ old('brand') }}">
            </div>
            <div class="form__group">
                <p class="form__content">商品の説明</p>
                <textarea class="form__textarea" name="description">{{ old('description') }}</textarea>
                <div class="form__error">
                    @error('description')
                    {{ $message }}
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
                    {{ $message }}
                    @enderror
                </div>
            </div>
            <div class="form__button">
                <button class="form__button-submit" type="submit">出品する</button>
            </div>
        </form>
    </div>
</div>

<script>
    const fileInput = document.getElementById('file-input');
    const imagePreview = document.getElementById('image-preview');

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
</script>
@endsection
