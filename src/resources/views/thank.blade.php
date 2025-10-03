@extends('layout.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/thank.css') }}">
@endsection

@section('content')
<div class="thank-container">
    <h2>出品できました！</h2>

    <div class="thank-buttons">
        <a href="{{ route('products.show', $id) }}" class="thank-btn">出品した商品の明細画面</a>
        <a href="{{ route('home') }}" class="thank-btn">ホームに移動</a>
    </div>
</div>
@endsection