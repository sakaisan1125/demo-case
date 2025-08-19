<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Item;
use App\Models\Purchase;
use App\Http\Requests\PurchaseRequest;
use Illuminate\Support\Facades\Auth;

class PurchaseController extends Controller
{
    // 購入画面を表示
    public function show($item_id)
    {
        $item = Item::findOrFail($item_id); // 商品情報取得
        $user = Auth::user(); // ログインユーザー取得
        $address = $user->address; // ユーザー住所取得

        return view('items.purchase', compact('item', 'user', 'address'));
    }

    // 購入処理
    public function store(PurchaseRequest $request, $item_id)
    {
        $validated = $request->validated(); // バリデーション済データ取得
        $item = Item::findOrFail($item_id); // 商品情報取得

        // 売り切れチェック
        if ($item->is_sold ?? false) {
            return redirect()->route('items.index')->with('error', 'この商品はすでに購入されています');
        }

        // 購入情報を保存
        $purchase = new Purchase();
        $purchase->user_id = Auth::id();
        $purchase->item_id = $item->id;
        $purchase->address = $validated['address'];
        $purchase->payment_method = $validated['payment_method'];
        $purchase->save();

        // 商品をSOLDに更新
        $item->is_sold = true;
        $item->save();

        return redirect()->route('items.index')->with('success', '購入が完了しました');
    }

}
