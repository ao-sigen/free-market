<!DOCTYPE html>

<html lang="ja">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Free Market</title>
    <link rel="stylesheet" href="{{ asset('css/sanitize.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/common.css') }}" />
    @yield('css')
</head>

<body>
    <header class="header">
        <div class="header__inner">
            <!-- 左：ロゴ -->
            <a class="header__logo" href="/">
                {!! file_get_contents(public_path('images/logo.svg')) !!}
            </a>

            <!-- 中央：検索欄 -->
            <div class="header__search">
                <form id="searchForm" action="{{ route('products.search') }}" method="GET">
                    <input type="text" id="searchInput" name="q" placeholder="商品名で検索">
                </form>
            </div>



            <!-- 右：ボタン -->
            <div class="header__buttons">
                @guest
                {{-- ログインしていない時 --}}
                <a href="{{ route('login') }}" class="btn btn-text">ログイン</a>
                @else
                {{-- ログインしている時 --}}
                <form action="{{ route('logout') }}" method="POST" style="display:inline;">
                    @csrf
                    <button type="submit" class="btn btn-text">ログアウト</button>
                </form>
                @endguest
                <a href="/mypage" class="btn btn-text">マイページ</a>
                <a href="/sell" class="btn btn-outlined">出品</a>
            </div>
        </div>
    </header>

    <main>
        @yield('content')
    </main>


</body>

</html>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const input = document.getElementById('searchInput');
        const results = document.getElementById('searchResults');
        let timer;

        input.addEventListener('input', function() {
            clearTimeout(timer);
            timer = setTimeout(() => {
                const query = input.value;

                fetch(`/search?q=${encodeURIComponent(query)}`, {
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest'
                        }
                    })
                    .then(response => response.text())
                    .then(html => {
                        results.innerHTML = html;
                    })
                    .catch(error => console.error(error));
            }, 2000); // 2秒
        });
    });
</script>


<script>
    document.getElementById('searchInput').addEventListener('keyup', function() {
        let query = this.value;

        fetch(`/search?q=${query}`)
            .then(response => response.text())
            .then(html => {
                document.getElementById('searchResults').innerHTML = html;
            })
            .catch(error => console.error('Error:', error));
    });
</script>