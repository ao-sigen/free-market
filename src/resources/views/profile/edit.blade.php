@extends('layout.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/profile.css') }}">
@endsection

@section('content')
<div class="profile-edit-container">
    <h2>プロフィール編集</h2>

    {{-- 成功メッセージ --}}
    @if(session('success'))
    <p class="success-message">{{ session('success') }}</p>
    @endif

    <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data" class="profile-form">
        @csrf
        @method('PATCH')

        {{-- アイコン画像 --}}
        <div class="form-group">
            <label>アイコン画像</label><br>
            @if($profile && $profile->icon)
            <img src="{{ asset('storage/' . $profile->icon) }}" alt="現在のアイコン" class="profile-icon">
            @endif
            <input type="file" name="icon">
            @error('icon') <p class="error-message">{{ $message }}</p> @enderror
        </div>

        {{-- 名前 --}}
        <div class="form-group">
            <label>名前</label><br>
            <input type="text" name="username" value="{{ old('username', $profile->username ?? '') }}" class="form-input">
            @error('username') <p class="error-message">{{ $message }}</p> @enderror
        </div>

        {{-- 郵便番号 --}}
        <div class="form-group">
            <label>郵便番号</label><br>
            <input type="text" name="postcode" value="{{ old('postcode', $profile->postcode ?? '') }}" class="form-input">
            @error('postcode') <p class="error-message">{{ $message }}</p> @enderror
        </div>

        {{-- 住所 --}}
        <div class="form-group">
            <label>住所</label><br>
            <input type="text" name="address" value="{{ old('address', $profile->address ?? '') }}" class="form-input">
            @error('address') <p class="error-message">{{ $message }}</p> @enderror
        </div>

        {{-- 建物名 --}}
        <div class="form-group">
            <label>建物名</label><br>
            <input type="text" name="building" value="{{ old('building', $profile->building ?? '') }}" class="form-input">
            @error('building') <p class="error-message">{{ $message }}</p> @enderror
        </div>

        {{-- 更新ボタン --}}
        <div class="form-group">
            <button type="submit" class="submit-button">更新する</button>
        </div>
    </form>
</div>
@endsection