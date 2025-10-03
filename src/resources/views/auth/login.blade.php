<!DOCTYPE html>

<html lang="ja">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Free Market</title>
    <link rel="stylesheet" href="{{ asset('css/sanitize.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/common.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/login.css') }}">
</head>

<body>
    <header class="header">
        <div class="header__inner">
            <!-- 左：ロゴ -->
            <a class="header__logo" href="/">
                {!! file_get_contents(public_path('images/logo.svg')) !!}
            </a>
        </div>
    </header>

    <main>
        <div class="auth-container">
            <h1 class="auth-title">ログイン</h1>

            @if (session('status'))
            <div class="auth-status">{{ session('status') }}</div>
            @endif

            <form method="POST" action="{{ route('login') }}" class="auth-form">
                @csrf

                <div class="form-group">
                    <label for="email">メールアドレス</label>
                    <input id="email" type="email" name="email" value="{{ old('email') }}" autofocus>
                    @error('email')
                    <div class="error">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="password">パスワード</label>
                    <input id="password" type="password" name="password" autocomplete="current-password">
                    @error('password')
                    <div class="error">{{ $message }}</div>
                    @enderror
                </div>

                {{-- 認証失敗時 --}}
                @error('login')
                <div class="error">{{ $message }}</div>
                @enderror

                <button type="submit" class="btn btn-outlined full-width">ログインする</button>
            </form>

            <div class="auth-links">
                @if (Route::has('register'))
                <a href="{{ route('register') }}">会員登録はこちら</a>
                @endif
            </div>
        </div>

    </main>
</body>

</html>