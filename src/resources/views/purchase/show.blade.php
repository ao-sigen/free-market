@extends('layout.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/purchase_show.css') }}">
@endsection

@section('content')
<div class="purchase-container">
    <div class="purchase-flex">

        {{-- 左カラム --}}
        <div class="left-column">
            <div class="left-top">
                <img src="{{ $product->images->isNotEmpty() 
                    ? asset('storage/' . $product->images->first()->path) 
                    : asset('images/noimage.jpg') }}"
                    alt="{{ $product->name }}" class="left-product-img">

                <div class="left-info">
                    <p class="left-name">{{ $product->name }}</p>
                    <p class="left-price">¥{{ number_format($product->price) }}</p>
                </div>
            </div>

            {{-- 配送先 --}}
            <div class="shipping-block">
                <div class="shipping-header">
                    <strong>配送先</strong>
                    <a href="{{ route('purchase.edit', ['product' => $product->id]) }}" class="change-address-btn">変更する</a>
                </div>
                <p><strong>郵便番号:</strong> {{ $user->profile->postcode ?? '未登録' }}</p>
                <p><strong>住所:</strong>
                    {{ $user->profile->address ?? '未登録' }}
                    @if($user->profile->building)
                    （{{ $user->profile->building }}）@endif
                </p>
            </div>

            {{-- 支払方法選択（左カラム一番下） --}}
            <div class="payment-select-block">
                <label for="payment_method"><strong>支払方法</strong></label>
                <select id="payment_method" name="payment_method">
                    <option value="konbini" {{ $selectedMethod === 'konbini' ? 'selected' : '' }}>コンビニ支払</option>
                    <option value="card" {{ $selectedMethod === 'card' ? 'selected' : '' }}>クレジットカード</option>
                </select>
            </div>
        </div>

        {{-- 右カラム --}}
        <div class="right-column">
            <div class="summary-right">
                <div class="summary-row">
                    <span class="label">商品金額</span>
                    <span class="value">¥{{ number_format($product->price) }}</span>
                </div>
                <div class="summary-row">
                    <span class="label">支払方法</span>
                    <span id="selectedMethod" class="value">{{ $selectedMethod === 'konbini' ? 'コンビニ支払' : 'クレジットカード' }}</span>
                </div>
            </div>

            {{-- 購入ボタンフォーム（POST） --}}
            <form method="POST" action="{{ route('purchase.store', ['product' => $product->id]) }}">
                @csrf
                <input type="hidden" name="payment_method" id="hidden_payment_method" value="{{ $selectedMethod }}">
                <button type="submit" class="buy-button" @if($product->sold) disabled @endif>
                    @if($product->sold) SOLD @else 購入する @endif
                </button>
            </form>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const select = document.getElementById('payment_method');
        const hiddenInput = document.getElementById('hidden_payment_method');
        const displayMethod = document.getElementById('selectedMethod');

        if (select && hiddenInput && displayMethod) {
            displayMethod.textContent = select.options[select.selectedIndex].text;

            select.addEventListener('change', function() {
                hiddenInput.value = this.value;
                displayMethod.textContent = this.options[this.selectedIndex].text;
            });
        }
    });
</script>
@endsection