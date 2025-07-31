<?php

namespace App\Http\Controllers; // コントローラーの名前空間を定義。PSR-4オートローダーでクラスを一意に識別するため。

use Illuminate\Http\Request; // HTTPリクエストを扱うクラスをインポート。フォーム送信やパラメータ取得に使う。
use App\Models\Item; // 商品モデル。DBのitemsテーブルと連携し、商品情報を取得・保存するため。
use App\Models\Purchase; // 購入モデル。DBのpurchasesテーブルと連携し、購入履歴を管理するため。
use App\Http\Requests\PurchaseRequest; // 購入時のバリデーションルールをまとめたリクエストクラス。安全なデータのみ受け付けるため。
use Illuminate\Support\Facades\Auth; // 認証ユーザー情報を取得するためのファサード。

class PurchaseController extends Controller // PurchaseControllerクラスを定義。コントローラーの基本機能を継承。
{
    // 購入画面の表示
    public function show($item_id) // 商品購入画面を表示するアクション。引数で商品IDを受け取る。
    {
        // 商品情報を取得（購入前に商品情報を表示するため）
        $item = Item::findOrFail($item_id); // 指定IDの商品をDBから取得。なければ404エラー。セキュリティ上findOrFail推奨。

        // ユーザーの住所情報を取得（初期値としてプロフィールの住所を表示するため）
        $user = Auth::user(); // 現在ログイン中のユーザー情報を取得。
        $address = $user->address; // ユーザーモデルのaddressカラムから住所を取得。初期表示用。

        // 購入画面を表示し、商品と住所情報を渡す
        return view('items.purchase', compact('item', 'user','address'));
        // Bladeテンプレート(items/purchase.blade.php)に商品情報と住所を渡して画面を描画。
    }

    // 購入処理
    public function store(PurchaseRequest $request, $item_id) // 購入フォーム送信時の処理。バリデーション済みリクエストと商品IDを受け取る。
    {
        // バリデーション済みデータを取得（支払い方法・住所が必須であることを保証）
        $validated = $request->validated(); // PurchaseRequestで定義したルールでバリデーション済みのデータのみ取得。

        // 商品情報を取得（購入対象の商品を特定するため）
        $item = Item::findOrFail($item_id); // 購入対象の商品をDBから取得。なければ404。

        // すでに売り切れの場合は処理を中断
        if ($item->is_sold ?? false) { // is_soldカラムがtrueなら
            return redirect()->route('items.index')->with('error', 'この商品はすでに購入されています');
            // 商品一覧にリダイレクトし、エラーメッセージを表示。二重購入防止。
        }

        // 購入レコードを作成（購入履歴を残すため）
        $purchase = new Purchase(); // 新しいPurchaseモデルのインスタンスを生成。
        $purchase->user_id = Auth::id(); // ログインユーザーのIDをセット。購入者を紐付ける。
        $purchase->item_id = $item->id;  // 購入した商品のIDをセット。
        $purchase->address = $validated['address']; // 配送先住所をセット。フォームから受け取った値。
        $purchase->payment_method = $validated['payment_method']; // 支払い方法をセット（例: 'convenience'や'card'）。
        $purchase->save(); // DBに保存。購入履歴が記録される。

        // 商品をSOLDにする（一覧や詳細で「SOLD」表示するため）
        $item->is_sold = true; // 商品のis_soldカラムをtrueに。売り切れ状態にする。
        $item->save(); // DBに保存。以降この商品は購入不可・SOLD表示になる。

        // 商品一覧画面にリダイレクト（要件通り遷移先を商品一覧にするため）
        return redirect()->route('items.index')->with('success', '購入が完了しました');
        // 商品一覧画面に遷移し、購入完了メッセージを表示。
    }

    // マイページ「購入した商品一覧」表示
    public function myPurchases()
    {
        // ログインユーザーの購入履歴を取得（マイページで購入商品を一覧表示するため）
        $purchases = Purchase::where('user_id', Auth::id())->with('item')->get();
        // ログインユーザーの購入履歴を全件取得。with('item')で商品情報も同時に取得（N+1問題対策）。

        // ビューに購入履歴を渡して表示
        return view('mypage.purchases', compact('purchases'));
        // mypage/purchases.blade.phpに購入履歴を渡して一覧表示。
    }
}