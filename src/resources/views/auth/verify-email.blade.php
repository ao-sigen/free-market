<!DOCTYPE html>

<html lang="ja">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Free Market</title>
    <link rel="stylesheet" href="{{ asset('css/sanitize.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/common.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/verify-email.css') }}">
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
        <div class="verify-container">
            <h2>メール認証が必要です</h2>
            <p>ご登録のメールアドレスに認証リンクを送信しました。</p>
            <p>メールを確認して認証を完了してください。</p>

            @if (session('message'))
            <p class="text-green">{{ session('message') }}</p>
            @endif

            <form method="POST" action="{{ route('verification.send') }}">
                @csrf
                <button type="submit">認証メールを再送する</button>
            </form>
        </div>
    </main>

</body>

</html>