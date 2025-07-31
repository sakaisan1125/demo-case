@extends('layouts.app')

@section('css')
  <link rel="stylesheet" href="{{ asset('css/purchase.css') }}">
@endsection

@section('content')
<form action="/purchase/{{ $item->id }}" method="POST">
  @csrf
  <div class="purchase-container">
    <div class="purchase-main">
        <div class="item-header">    
            <div class="item-image-placeholder">
                @if ($item->image_path)
                <img src="{{ $item->image_path }}" alt="商品画像" class="item-image">
                @else
                <span class="item-image-text">商品画像</span>
                @endif
            </div>
            <div class="item-info">
                <div class="item-name">{{ $item->name }}</div>
                <div class="item-price">￥{{ number_format($item->price) }}</div>
            </div>
        </div>
      <hr>
      <div class="payment-area">
        <label>支払い方法</label>
        <select name="payment_method" id="payment_method" required class="payment-select">
          <option value="" hidden disabled selected>選択してください</option>
          <!-- 「選択してください」は選択不可のダミー選択肢にし、
          実際に選べるのは「コンビニ支払い」「カード支払い」の2択にしたい場合は、
          <option value="">選択してください</option> に disabled selected を付ける -->
          <!-- hidden を付けることで、ドロップダウンを開いたときに「選択してください」がリストに出ません。 -->
          <option value="convenience">コンビニ支払い</option>
          <option value="card">カード支払い</option>
        </select>
      </div>
      <hr>
      <div class="address-area">
        <div class="address-label-row">
            <label>配送先</label>
            <a href="{{ route('address.edit', ['item_id' => $item->id]) }}" class="address-edit-link">変更する</a>
        </div>
        <div class="address-info">
          〒{{ $user->zipcode }}<br>
          {{ $user->address }}
        </div>
      </div>
      <hr>
    </div>
    <div class="purchase-summary">
      <div class="summary-table">
        <div class="summary-row">
          <div class="summary-label">商品代金</div>
          <div class="summary-value">￥{{ number_format($item->price) }}</div>
        </div>
        <div class="summary-row">
          <div class="summary-label">支払い方法</div>
          <div class="summary-value" id="summary-payment-method">-</div>
        </div>
      </div>
      <button type="submit" class="purchase-btn">購入する</button>
    </div>
  </div>
</form>
@endsection