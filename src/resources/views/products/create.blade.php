@extends('layout.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/product_create.css') }}">
@endsection

@section('content')
<div class="product-create-container">
    <h2>商品を出品する</h2>

    <form action="{{ route('products.store') }}" method="POST" class="product-form" enctype="multipart/form-data">
        @csrf

        <!-- 商品画像 -->
        <label>商品画像</label>
        <input type="file" name="images[]" multiple accept="image/*">
        @error('images') <p class="error">{{ $message }}</p> @enderror
        @error('images.*') <p class="error">{{ $message }}</p> @enderror

        <!-- カテゴリ（複数選択可能） -->
        <label>カテゴリ</label>
        <div class="category-container">
            @foreach($categories as $category)
            <input type="checkbox" id="cat-{{ $loop->index }}" name="categories[]" value="{{ $category->id }}">
            <label for="cat-{{ $loop->index }}" class="category-btn">{{ $category->name }}</label>
            @endforeach
        </div>
        @error('categories')<p class="error">{{ $message }}</p>@enderror

        <!-- 商品の状態 -->
        <label>商品の状態</label>
        <select name="condition_id">
            @foreach($conditions as $condition)
            <option value="{{ $condition->id }}">{{ $condition->name }}</option>
            @endforeach
        </select>
        @error('condition_id')
        <p class="error">{{ $message }}</p>
        @enderror


        <!-- 商品名 -->
        <label>商品名</label>
        <input type="text" name="name" value="{{ old('name') }}">
        @error('name')<p class="error">{{ $message }}</p>@enderror

        <!-- ブランド名 -->
        <label>ブランド名</label>
        <input type="text" name="brand" value="{{ old('brand') }}">
        @error('brand')<p class="error">{{ $message }}</p>@enderror

        <!-- 商品説明 -->
        <label>商品説明</label>
        <textarea name="description">{{ old('description') }}</textarea>
        @error('description')<p class="error">{{ $message }}</p>@enderror

        <!-- 販売価格 -->
        <label>販売価格</label>
        <input type="number" name="price" value="{{ old('price') }}">
        @error('price')<p class="error">{{ $message }}</p>@enderror

        <button type="submit">出品する</button>
    </form>
</div>
@endsection