@extends('layout.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/purchase_thank.css') }}">
@endsection

@section('content')
<div class="purchase-complete">
    <h2>購入ありがとうございました！</h2>

    <div class="product-info">
        <p>商品: {{ $purchase->product->name }}</p>
        <p>価格: ¥{{ $purchase->product->price }}</p>
        <p>支払方法: {{ $paymentMethod ?? '不明' }}</p>
    </div>

    @if($paymentMethod === 'konbini' && $voucher)
    <p>支払コード: {{ $voucher['number'] }}</p>
    <a href="{{ $voucher['hosted_voucher_url'] }}" target="_blank">支払票を表示</a>
    @endif

    @if($paymentMethod === 'card')
    <p>クレジットカードでの決済が完了しました</p>
    @endif


    <div class="shipping-info">
        <h3>配送先情報</h3>
        <p><strong>お名前:</strong> {{ $user->profile->username ?? '未登録' }}</p>
        <p><strong>住所:</strong> {{ $user->profile->address ?? '未登録' }}</p>
        <p><strong>建物名:</strong> {{ $user->profile->building ?? '-' }}</p>
        <p><strong>郵便番号:</strong> {{ $user->profile->postcode ?? '未登録' }}</p>
    </div>

    <a href="{{ route('home') }}" class="btn">トップページに戻る</a>
</div>
@endsection