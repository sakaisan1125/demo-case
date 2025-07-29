@extends('layouts.app')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/mypage.css') }}">
@endsection

@section('content')
<div class="mypage-container">
    <div class="profile-area">
        <div class="profile-icon"></div>
        <div class="profile-info">
            <div class="profile-username">{{ Auth::user()->name ?? 'ユーザー名' }}</div>
        </div>
        <a href="{{ route('mypage.profile.edit') }}" class="profile-edit-btn">プロフィールを編集</a>
    </div>

    <div class="mypage-tab-menu">
        <a href="#" class="mypage-tab active">出品した商品</a>
        <a href="#" class="mypage-tab">購入した商品</a>
    </div>

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
            <p>出品した商品はありません。</p>
        @endforelse
    </div>
</div>
@endsection