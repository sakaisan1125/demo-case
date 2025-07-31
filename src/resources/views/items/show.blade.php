@extends('layouts.app')

@section('css')
  <link rel="stylesheet" href="{{ asset('css/show.css') }}">
@endsection


@section('content')
<div class="item-detail-container">

  {{-- 画像エリア --}}
  <div class="item-detail-image">
    <img src="{{ $item->image_path }}" alt="商品画像">
  </div>

  {{-- 詳細情報エリア --}}
  <div class="item-detail-info">
    {{-- 商品名・ブランド --}}
    <h2 class="item-title">{{ $item->name }}</h2>
    <div class="item-brand">{{ $item->brand }}</div>

    {{-- 価格 --}}
    <div class="item-price">
      ￥{{ number_format($item->price) }} <span class="tax-in">（税込）</span>
    </div>

    {{-- いいね・コメントアイコン等（デザインによって後から） --}}
    {{-- いいねボタン --}}
  @auth
    <div class="like-area">
      @if (auth()->user()->likes->where('item_id', $item->id)->count())
        <form action="{{ route('items.unlike', $item) }}" method="POST" style="display:inline;">
          @csrf
          @method('DELETE')
          <button type="submit" class="like-btn liked">♥</button>
        </form>
      @else
        <form action="{{ route('items.like', $item) }}" method="POST" style="display:inline;">
          @csrf
          <button type="submit" class="like-btn">♡</button>
        </form>
      @endif
      <span class="like-count">{{ $item->likes->count() }}</span>
    </div>
  @endauth

  {{-- 未ログインの場合はボタン非表示またはログイン誘導 --}}
  @guest
    <div class="like-area">
      <span class="like-btn disabled" title="ログインしてください">♡</span>
      <span class="like-count">{{ $item->likes->count() }}</span>
    </div>
  @endguest


    {{-- 購入ボタン --}}
   {{-- 購入ボタン（formからaタグに変更） --}}
    <a href="{{ route('purchase.show', $item->id) }}" class="buy-btn">購入手続きへ</a>

    {{-- 商品説明 --}}
    <div class="item-section">
      <div class="section-title">商品説明</div>
      <div class="item-description">
        <div>カラー：{{ $item->color ?? '未設定' }}</div>
        <div>新品</div>
        <div>{{ $item->description }}</div>
        <div>購入後、即発送いたします。</div>
      </div>
    </div>

    {{-- 商品の情報 --}}
    <div class="item-section">
      <div class="section-title">商品の情報</div>
      <div>
        <span class="category-label">カテゴリー</span>
        @foreach($item->categories as $category)
        <span class="category-badge">{{ $category->name }}</span>
        @endforeach
      </div>
      <div class="item-condition">
        <span class="item-condition-label">商品の状態</span>
        <span class="item-condition-badge">{{ $item->condition }}</span>
      </div>
    </div>

    {{-- コメント欄 --}}
    <div class="item-section">
      <div class="section-title">コメント (1)</div>
      {{-- コメント表示例（ダミー） --}}
      <div class="comment">
        <span class="avatar"></span>
        <span class="username">admin</span>
        <br>
        <input class="comment-box" value="こちらにコメントが入ります。" readonly>
      </div>
      {{-- コメント投稿 --}}
      <form action="#" method="POST">
        @csrf
        <div class="item-comment">商品へのコメント</div>
        <textarea name="body" rows="10" class="comment-textarea"></textarea>
        <br>
        <button type="submit" class="comment-btn">コメントを送信する</button>
      </form>
    </div>
  </div>
</div>
@endsection
