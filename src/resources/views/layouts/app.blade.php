<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FleaMarket</title>
    <link rel="stylesheet" href="{{ asset('css/sanitize.css') }}">
    <link rel="stylesheet" href="{{ asset('css/common.css') }}">
    @yield('css')
</head>

<body>
    <header class="header">
        <div class="header__inner">
            <h1 class="header__logo">
                <img src="{{ asset('logo.svg') }}" alt="logo" width="100%">
            </h1>
            @if (!request()->is('auth/*'))
            <input type="text" placeholder="なにをお探しですか？">
            <nav class="header__nav">
                <ul class="header__nav-list">
                    <li><a class="nav__link" href="">ログアウト</a></li>
                    <li><a class="nav__link" href="">マイページ</a></li>
                    <li><button class="nav__button" onclick="location.href=''">出品</button></li>
                </ul>
            </nav>
            @endif
        </div>
    </header>

    <main>
        @yield('content')
    </main>
</body>
</html>