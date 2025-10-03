<!DOCTYPE html>

<html lang="ja">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Free Market</title>
    <link rel="stylesheet" href="{{ asset('css/sanitize.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/common.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/register.css') }}">
</head>

<body>
    <header class="header">
        <div class="header__inner">
            <a class="header__logo" href="/">
                {!! file_get_contents(public_path('images/logo.svg')) !!}
            </a>
        </div>
    </header>

    <main>
        <div class="register-container">
            <h2 class="register-title">会員登録</h2>

            <form method="POST" action="{{ route('register') }}" novalidate>
                @csrf

                {{-- 名前 --}}
                <div class="form-group">
                    <label for="username">名前</label>
                    <input id="username" type="text" name="username" value="{{ old('username') }}">
                    @error('username')
                    <div class="error-message">{{ $message }}</div>
                    @enderror
                </div>

                {{-- メール --}}
                <div class="form-group">
                    <label for="email">メールアドレス</label>
                    <input id="email" type="email" name="email" value="{{ old('email') }}">
                    @error('email')
                    <div class="error-message">{{ $message }}</div>
                    @enderror
                </div>

                {{-- パスワード --}}
                <div class="form-group">
                    <label for="password">パスワード</label>
                    <input id="password" type="password" name="password">
                    @error('password')
                    <div class="error-message">{{ $message }}</div>
                    @enderror
                </div>

                {{-- 確認用パスワード --}}
                <div class="form-group">
                    <label for="password_confirmation">確認用パスワード</label>
                    <input id="password_confirmation" type="password" name="password_confirmation">
                </div>
                @error('password_confirmation')
                <div class="error-message">{{ $message }}</div>
                @enderror

                {{-- 登録ボタン --}}
                <button type="submit" class="btn-register">登録する</button>
            </form>

            <a href="{{ route('login') }}" class="login-link">ログインはこちら</a>
        </div>
    </main>
</body>

</html>