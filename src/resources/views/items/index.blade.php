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
    @foreach ($items as $item)
      <div class="item-card">
        <a href="{{ route('items.show', $item->id) }}">
          <img src="{{ $item->image_path }}" alt="商品画像" class="item-image">
          <div class="item-name">{{ $item->name }}</div>
        </a>
      </div>
    @endforeach
  </div>
</div>
@endsection
