<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\MypageController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', [ItemController::class, 'index'])->name('items.index');
// Route::get('/items', [ItemController::class, 'index'])->name('items.list');
Route::get('/items/recommend', [ItemController::class, 'recommend'])->name('items.recommend');
Route::get('/items/mylist', [ItemController::class, 'mylist'])->name('items.mylist');
Route::get('/item/{id}', [ItemController::class, 'show'])->name('items.show');
// 出品ページの表示
Route::get('/sell', [ItemController::class, 'create'])->name('items.create')->middleware('auth');

// 出品処理の受け取り
Route::post('/sell', [ItemController::class, 'store'])->name('items.store')->middleware('auth');

// マイページ（ログインユーザーのみ閲覧できるようにミドルウェアauthを付与）
Route::middleware('auth')->group(function () {
    // マイページ
    Route::get('/mypage', [MypageController::class, 'index'])->name('mypage.index');
    Route::get('/mypage/profile', [MypageController::class, 'editProfile'])->name('mypage.profile.edit');
    Route::post('/mypage/profile', [MypageController::class, 'updateProfile'])->name('mypage.profile.update');

    // いいね機能
    Route::post('/items/{item}/like', [ItemController::class, 'like'])->middleware('auth')->name('items.like');
    Route::delete('/items/{item}/unlike', [ItemController::class, 'unlike'])->middleware('auth')->name('items.unlike');
    // ...既存ルート...
    Route::get('/purchase/{item}', [App\Http\Controllers\PurchaseController::class, 'show'])->name('purchase.show');
    Route::post('/purchase/{item}', [App\Http\Controllers\PurchaseController::class, 'store'])->name('purchase.store');
    Route::get('/address/edit', [App\Http\Controllers\AddressController::class, 'edit'])->name('address.edit');
    Route::post('/address/update', [App\Http\Controllers\AddressController::class, 'update'])->name('address.update');
    // コメント投稿
    Route::post('/items/{item}/comments', [App\Http\Controllers\CommentController::class, 'store'])->name('comments.store');
});
