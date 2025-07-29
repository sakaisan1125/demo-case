<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>フリマアプリ</title>
  <link rel="stylesheet" href="{{ asset('css/sanitize.css') }}">
  <link rel="stylesheet" href="{{ asset('css/app.css') }}">
  @yield('css')

</head>
<body>

  <header class="header">
    <div class="header__left">
      <img src="{{ asset('images/coachtech-logo.svg') }}" alt="COACHTECH ロゴ">
    </div>

    <div class="header__center">
      <form action="{{ route('items.index') }}" method="GET">
        <input type="text" name="keyword" placeholder="なにをお探しですか？">
      </form>
    </div>

    <div class="header__right">
      {{-- <a href="{{ route('login') }}">ログイン</a> --}}
      {{-- <a href="{{ route('mypage.index') }}">マイページ</a> --}}
      {{-- <a href="{{ route('items.create') }}">出品</a> --}}

    </div>

    <form method="POST" action="{{ route('logout') }}" class="logout-form">
    @csrf
    <button type="submit" class="logout-btn">ログアウト</button>
    </form>


  </header>

  <main class="container">
    @yield('content')
  </main>

</body>
</html>
