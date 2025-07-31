@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/address-edit.css') }}">
@endsection

@section('content')
<div class="address-edit-container">
    <h2 class="address-edit-title">住所の変更</h2>
    <form action="{{ route('address.update') }}" method="POST" class="address-edit-form">
        @csrf
        <div class="form-group">
            <label for="zip">郵便番号</label>
            <input type="text" name="zip" id="zip" value="{{ old('zip', $user->zip) }}">
        </div>
        <div class="form-group">
            <label for="address">住所</label>
            <input type="text" name="address" id="address" value="{{ old('address', $user->address) }}">
        </div>
        <div class="form-group">
            <label for="building">建物名</label>
            <input type="text" name="building" id="building" value="{{ old('building', $user->building ?? '') }}">
        </div>
        <button type="submit" class="address-edit-btn">更新する</button>
    </form>
</div>
@endsection