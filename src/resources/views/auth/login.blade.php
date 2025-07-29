@extends('layouts.auth')

@section('css')
  <link rel="stylesheet" href="{{ asset('css/auth.css') }}">
@endsection

@section('content')
<div class="register-wrap">
  <div class="register-title">ログイン</div>
  <form class="register-form" method="POST" action="{{ route('login') }}">
    @csrf

    <div class="register-group">
      <label for="email">メールアドレス</label>
      <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus>
      @error('email') <div class="form-error">{{ $message }}</div> @enderror
    </div>

    <div class="register-group">
      <label for="password">パスワード</label>
      <input id="password" type="password" name="password" required autocomplete="current-password">
      @error('password') <div class="form-error">{{ $message }}</div> @enderror
    </div>

    <button type="submit" class="register-btn">ログイン</button>
  </form>
  <div class="register-link">
    <a href="{{ route('register') }}">新規登録はこちら</a>
  </div>
</div>
@endsection
