<?php
// PHPファイルの開始を宣言。Laravelの全てのPHPファイルはこれで始まる。

namespace App\Http\Controllers;
// このファイルがApp\Http\Controllers名前空間に属していることを示す。
// Laravelのコントローラーはこの名前空間に配置されるのが一般的。

use Illuminate\Http\Request;
// HTTPリクエスト（フォーム送信やURLパラメータなど）を扱うためのクラスをインポート。
// バリデーションや入力値取得に使う。

use Illuminate\Support\Facades\Auth;
// 認証済みユーザー情報を取得するためのファサードをインポート。
// ログインユーザーの情報取得や認証チェックに使う。
use App\Http\Requests\AddressRequest;
// 住所に関するリクエストバリデーションを行うためのクラスをインポート。
// 住所編集フォームの入力値を検証するために使用する。

class AddressController extends Controller
// AddressControllerクラスを定義。Controllerクラスを継承している。
// これによりLaravelのコントローラーとして機能する。
{
    // 住所編集画面の表示
    public function edit(Request $request)
    // 住所編集画面を表示するためのメソッド。ルートから呼び出される。
    {
        $user = Auth::user();
        // 現在ログインしているユーザー情報を取得。
        // これにより、そのユーザーの住所情報を編集画面に表示できる。

        // item_idが来ていればセッションに保存
        if ($request->has('item_id')) {
            session(['last_item_id' => $request->input('item_id')]);
        }

        return view('address.edit', compact('user'));
        // resources/views/address/edit.blade.php ビューを表示。
        // compact('user')で$user変数をビューに渡す。
        // これにより、Bladeテンプレート内で$user->zipや$user->addressが使える。
    }

    // 住所更新処理
    public function update(AddressRequest $request)
    // 住所編集フォームからPOSTされたデータを受け取り、DBに保存するメソッド。
    // $requestにはフォームの入力値が入っている。
    {
        $user = Auth::user();
        $user->zipcode = $request->input('zip');
        $user->address = $request->input('address');
        $user->building = $request->input('building');
        $user->save();

        $itemId = session('last_item_id');
        if ($itemId) {
            return redirect()->route('purchase.show', ['item' => $itemId])
                            ->with('success', '住所を更新しました');
        } else {
            return redirect()->route('mypage.index')->with('success', '住所を更新しました');
        }
        // 住所更新後、購入画面（purchase.showルート）にリダイレクト。
        // session('last_item_id')は直前に見ていた商品IDをセッションから取得している想定。
        // with('success', ...)で「住所を更新しました」というメッセージをフラッシュメッセージとして渡す。
        // これにより、画面上に成功メッセージが表示できる。
    }
}