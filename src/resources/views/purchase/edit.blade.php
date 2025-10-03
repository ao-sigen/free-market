@extends('layout.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/purchase_edit.css') }}">
@endsection

@section('content')
<div class="edit-container">
    <h2>配送先の変更</h2>

    <form method="POST" action="{{ route('purchase.address.update', ['product' => $purchase->product_id]) }}">
        @csrf
        @method('PATCH') {{-- PATCHとして送る --}}

        <div class="form-group">
            <label>郵便番号</label>
            <input type="text" name="postcode" value="{{ old('postcode', $user->profile->postcode) }}">
        </div>

        <div class="form-group">
            <label>住所</label>
            <input type="text" name="address" value="{{ old('address', $user->profile->address) }}">
        </div>

        <div class="form-group">
            <label>建物名</label>
            <input type="text" name="building" value="{{ old('building', $user->profile->building) }}">
        </div>

        <button type="submit">更新する</button>
    </form>

</div>
@endsection