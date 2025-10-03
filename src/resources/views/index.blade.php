@extends('layout.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/index.css') }}">
@endsection

@section('content')
<div class="my__profile">
  @auth
  <div class="profile-box">
    <!-- プロフィール画像 -->
    <img src="{{ auth()->user()->profile && auth()->user()->profile->icon
                    ? asset('storage/' . auth()->user()->profile->icon)
                    : asset('images/default-icon.png') }}"
      alt="プロフィール画像" class="profile-icon" style="width:100px; height:100px; object-fit:cover; border-radius:50%;">


    <!-- ユーザー名 -->
    <span class="profile-name">{{ auth()->user()->profile ? auth()->user()->profile->username : '' }}</span>

    <!-- プロフィール編集ボタン -->
    <a href="{{ route('profile.edit') }}" class="edit_btn-outlined">
      プロフィールを編集
    </a>
  </div>
  @endauth
</div>

<nav class="sub-nav">
  <a href="/recommended" class="sub-nav__item">おすすめ</a>
  <a href="{{ route('mypage') }}" class="sub-nav__item">マイリスト</a>
</nav>

<div id="searchResults"></div>


<div class="product-list">
  @foreach ($products as $product)
  <div class="product-card">
    <div class="product-card-link">
      <a href="{{ route('products.show', $product->id) }}">
        <img class="product-card__img"
          src="{{ $product->images->isNotEmpty() 
                         ? asset('storage/' . $product->images->first()->path) 
                         : asset('images/noimage.jpg') }}"
          alt="{{ $product->name }}">
        <p>{{ $product->name }}</p>
      </a>
    </div>
  </div>
  @endforeach

</div>

@endsection