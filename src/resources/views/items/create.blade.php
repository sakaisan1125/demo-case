@extends('layouts.app')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/exhibition.css') }}">
@endsection

@section('content')
<div class="exhibition-container">
    <h2>商品の出品</h2>

    {{-- エラーメッセージ --}}
    @if ($errors->any())
        <div class="error-message">
            <ul>
                @foreach ($errors->all() as $error)
                    <li style="color:red;">{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('items.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="form-group image-upload-group">
            <label for="image">商品画像</label>
            <label class="image-drop-area" for="image">
                <span>画像を選択する</span>
                <input type="file" name="image" id="image" accept="image/jpeg,image/png" required>
            </label>
        </div>

        <h3 class="section-title">商品の詳細</h3>

        <div class="form-group">
            <label>カテゴリー</label>
            <div class="category-list">
                @foreach ($categories as $category)
                    <label class="category-tag">
                        <input type="checkbox" name="category_id[]" value="{{ $category->id }}" style="display:none;"
                            {{ (collect(old('category_id'))->contains($category->id)) ? 'checked' : '' }}>
                        <span>{{ $category->name }}</span>
                    </label>
                @endforeach
            </div>
        </div>

        <div class="form-group">
            <label for="condition">商品の状態</label>
            <select name="condition" id="condition" required>
                <option value="">選択してください</option>
                <option value="新品" {{ old('condition') == '新品' ? 'selected' : '' }}>新品</option>
                <option value="良好" {{ old('condition') == '良好' ? 'selected' : '' }}>良好</option>
                <option value="目立った傷や汚れなし" {{ old('condition') == '目立った傷や汚れなし' ? 'selected' : '' }}>目立った傷や汚れなし</option>
                <option value="やや傷や汚れあり" {{ old('condition') == 'やや傷や汚れあり' ? 'selected' : '' }}>やや傷や汚れあり</option>
                <option value="状態が悪い" {{ old('condition') == '状態が悪い' ? 'selected' : '' }}>状態が悪い</option>
            </select>
        </div>

        <h3 class="section-title">商品名と説明</h3>

        <div class="form-group">
            <label for="name">商品名</label>
            <input type="text" name="name" id="name" value="{{ old('name') }}" required maxlength="255">
        </div>

        <div class="form-group">
            <label for="brand">ブランド名</label>
            <input type="text" name="brand" id="brand" value="{{ old('brand') }}">
        </div>

        <div class="form-group">
            <label for="description">商品説明</label>
            <textarea name="description" id="description" rows="4" maxlength="255" required>{{ old('description') }}</textarea>
        </div>

        <div class="form-group">
            <label for="price">販売価格</label>
            <input type="number" name="price" id="price" value="{{ old('price') }}" min="0" required placeholder="￥">
        </div>

        <button type="submit" class="exhibition-btn">出品する</button>
    </form>
</div>
@endsection