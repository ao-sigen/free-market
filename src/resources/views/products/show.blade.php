@extends('layout.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/product_show.css') }}">
@endsection

@section('content')
<div class="product-detail">
    <!-- 商品画像 -->
    <img src="{{ $product->images->isNotEmpty() 
        ? asset('storage/' . $product->images->first()->path) 
        : asset('images/noimage.jpg') }}"
        alt="{{ $product->name }}"
        class="product-img">

    <!-- 商品情報 -->
    <div class="product-info">
        <h2 class="product-name">{{ $product->name }}</h2>
        <p><strong>ブランド名:</strong> {{ $product->brand ?? '不明' }}</p>
        <p class="product-price">¥{{ number_format($product->price) }}</p>

        <!-- お気に入りとコメント数 -->
        <div class="rating-comment">
            <!-- お気に入りボタン（独立フォーム） -->
            <div class="favorite-wrapper">
                @auth
                <form action="{{ route('products.favorite', $product->id) }}" method="POST" style="display:inline;">
                    @csrf
                    <button type="submit" class="favorite-btn">
                        @if($product->favorites && $product->favorites->contains(auth()->id()))
                        ★ お気に入り
                        @else
                        ☆ お気に入り
                        @endif
                    </button>
                </form>
                @else
                <p>お気に入り登録には <a href="{{ route('login') }}">ログイン</a> が必要です。</p>
                @endauth
            </div>


            <!-- コメント数表示 -->
            <div class="comment-count">
                💬 コメント ({{ $comments->count() }})
            </div>
        </div>

        <p class="product-description">{{ $product->description }}</p>

        <h3>商品の情報</h3>
        <p><strong>カテゴリー:</strong> {{ $product->category ?? '不明' }}</p>
        <p><strong>商品の状態:</strong> {{ $product->condition->name }}</p>
    </div>
</div>

<!-- コメントセクション（独立フォーム） -->
<div class="comments-section">
    <h3>コメント</h3>
    <div class="comments">
        @foreach($comments as $comment)
        <div class="comment-item">
            <div class="comment-user">
                <img src="{{ $comment->user->profile->icon ?? asset('images/default-user.png') }}"
                    alt="icon" class="comment-icon-img">
                <span class="comment-username">{{ $comment->user->name ?? '匿名' }}</span>
            </div>
            <p class="comment-text">{{ $comment->text }}</p>
        </div>
        @endforeach
    </div>

    @auth
    <h4>商品へのコメント</h4>
    <form action="{{ route('products.comment', $product->id) }}" method="POST" class="comment-form">
        @csrf
        <input type="text" name="text" placeholder="コメントを入力" required>
        <button type="submit">コメント送信</button>
    </form>
    @endauth

    @guest
    <p>コメントするには <a href="{{ route('login') }}">ログイン</a> が必要です。</p>
    @endguest

</div>



<!-- 購入フォーム（独立フォーム） -->
<div class="purchase-form">
    <form method="POST" action="{{ route('purchase.store', ['product' => $product->id]) }}">
        @csrf
        <p><strong>送付先住所:</strong> {{ $user->profile->address ?? '未登録' }}</p>

        @if($product->sold)
        <button class="buy-button" disabled>SOLD</button>
        @else
        <a href="{{ route('purchase.show', ['product' => $product->id]) }}" class="buy-button">
            この商品を購入する
        </a>
        @endif

    </form>
</div>
@endsection