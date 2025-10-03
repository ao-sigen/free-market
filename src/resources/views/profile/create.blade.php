@extends('layout.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/create.css') }}">
@endsection

@section('content')
<div class="profile-container">
    <h2>プロフィールを作成する</h2>
    @if(session('success'))
    <p class="success">{{ session('success') }}</p>
    @endif

    <form method="POST" action="{{ route('profile.store') }}" enctype="multipart/form-data" novalidate>
        @csrf
        @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        <div class="form-group">
            <label for="icon">アイコン</label>
            <input type="file" name="icon" id="icon" accept="image/*">
            @error('icon')
            <p class="error">{{ $message }}</p>
            @enderror
        </div>

        <div class="form-group">
            <label for="username">ユーザー名</label>
            <input id="username" type="text" name="username" value="{{ old('username') }}">
            @error('username')
            <p class="error">{{ $message }}</p>
            @enderror
            @if ($errors->any())
            <div class="error-box">
                <ul>
                    @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif

        </div>

        <div class="form-group">
            <label for="postcode">郵便番号</label>
            <input id="postcode" type="text" name="postcode">
            @error('postcode')
            <p class="error">{{ $message }}</p>
            @enderror
        </div>

        <div class="form-group">
            <label for="address">住所</label>
            <input id="address" type="text" name="address">
            @error('address')
            <p class="error">{{ $message }}</p>
            @enderror
        </div>

        <div class="form-group">
            <label for="building">建物名</label>
            <input id="building" type="text" name="building">
            @error('building')
            <p class="error">{{ $message }}</p>
            @enderror
        </div>

        <button type="submit" class="btn-primary">更新</button>
    </form>
</div>
@endsection