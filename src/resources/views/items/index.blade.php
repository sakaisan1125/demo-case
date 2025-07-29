@extends('layouts.app')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/index.css') }}">
@endsection

@section('content')
<div class="container">
  {{-- タブ --}}
  <div class="tab-menu">
    <a href="{{ route('items.index') }}"
       class="tab {{ $tab !== 'mylist' ? 'active' : '' }}">おすすめ</a>
    <a href="{{ route('items.index', ['tab' => 'mylist']) }}"
       class="tab {{ $tab === 'mylist' ? 'active' : '' }}">マイリスト</a>
  </div>
  {{-- 商品一覧 --}}
  <div class="item-list">
    @forelse ($items as $item)
      <div class="item-card">
        <a href="{{ route('items.show', $item->id) }}">
          <div class="item-image-placeholder">
            @if ($item->image_path)
              <img src="{{ $item->image_path }}" alt="商品画像" class="item-image">
            @else
              <span class="item-image-text">商品画像</span>
            @endif
            @if (!empty($item->is_sold) && $item->is_sold)
              <span class="sold-badge">SOLD</span>
            @endif
          </div>
          <div class="item-name">{{ $item->name }}</div>
        </a>
      </div>
    @empty
      {{-- 未認証時やアイテムがない場合は何も表示しない --}}
    @endforelse
  </div>
</div>
@endsection