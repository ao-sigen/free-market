@extends('layout.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/mypage.css') }}">
@endsection

@section('content')
<div class="mypage-container">
    {{-- プロフィール --}}
    <div class="profile-section">
        <img src="{{ $user->profile->icon ?? asset('images/default_icon.png') }}" alt="アイコン" class="profile-icon">
        <div class="profile-info">
            <p class="name">{{ $user->name }}（{{ $user->profile->username ?? '未設定' }}）</p>
            <p>郵便番号: {{ $user->profile->postcode ?? '未登録' }}</p>
            <p>住所: {{ $user->profile->address ?? '未登録' }} {{ $user->profile->building ?? '' }}</p>
        </div>
    </div>

    {{-- 検索欄 --}}
    <div class="profile-search">
        <form method="GET" class="search-form">
            <select name="sort">
                <option value="latest" @if($order==='latest' ) selected @endif>新着順</option>
                <option value="price_asc" @if($order==='price_asc' ) selected @endif>価格の安い順</option>
                <option value="price_desc" @if($order==='price_desc' ) selected @endif>価格の高い順</option>
            </select>
            <button type="submit">並び替え</button>
        </form>
    </div>

    {{-- マイページ商品一覧 --}}
    <div class="mypage-products">
        {{-- 出品商品 --}}
        <h3>出品商品</h3>
        <div class="product-grid">
            @forelse($sales as $product)
            <div class="product-card">
                <img src="{{ $product->images->isNotEmpty() ? asset('storage/' . $product->images->first()->path) : asset('images/noimage.jpg') }}" alt="{{ $product->name }}">
                <p>{{ $product->name }}</p>
                <p class="product-price">¥{{ number_format($product->price) }}</p>
            </div>
            @empty
            <p>出品商品はありません。</p>
            @endforelse
        </div>
        {{ $sales->links('vendor.pagination.simple-numbers') }}


        {{-- お気に入り商品 --}}
        @if($page === 'favorite')
        <h3>お気に入り商品</h3>
        <div class="product-grid">
            @foreach($favorites as $product)
            <div class="product-card">
                <img src="{{ $product->images->isNotEmpty() ? asset('storage/' . $product->images->first()->path) : asset('images/noimage.jpg') }}" alt="{{ $product->name }}">
                <p>{{ $product->name }}</p>
                <p class="product-price">¥{{ number_format($product->price) }}</p>
            </div>
            @endforeach
        </div>
        @endif

        {{-- 購入商品 --}}
        <h3>購入商品</h3>
        <div class="product-grid">
            @forelse($purchases as $purchase)
            <div class="product-card">
                <img src="{{ $purchase->product->images->isNotEmpty() ? asset('storage/' . $purchase->product->images->first()->path) : asset('images/noimage.jpg') }}" alt="{{ $purchase->product->name }}">
                <p>{{ $purchase->product->name }}</p>
                <p class="product-price">¥{{ number_format($purchase->product->price) }}</p>
            </div>
            @empty
            <p>購入商品はありません。</p>
            @endforelse
        </div>
    </div>
</div>
@endsection