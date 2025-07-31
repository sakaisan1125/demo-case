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
    public function update(Request $request)
    // 住所編集フォームからPOSTされたデータを受け取り、DBに保存するメソッド。
    // $requestにはフォームの入力値が入っている。
    {
        $request->validate([
            'zip' => 'required|string|max:10',
            // zip（郵便番号）は必須、文字列、最大10文字までとバリデーション。
            'address' => 'required|string|max:255',
            // address（住所）は必須、文字列、最大255文字までとバリデーション。
            'building' => 'nullable|string|max:255',
            // building（建物名）は任意、文字列、最大255文字までとバリデーション。
            // nullableなので、空でもOK。
        ]);
        // バリデーションに失敗した場合は自動的に前の画面にリダイレクトし、エラー内容を表示。

        $user = Auth::user();
        // 再度、現在ログイン中のユーザー情報を取得。
        // セキュリティのため、リクエストからuser_idを受け取らず、必ず認証情報から取得する。

        $user->zipcode = $request->input('zip');
        // フォームから送信されたzip（郵便番号）をユーザーのzipプロパティに代入。

        $user->address = $request->input('address');
        // フォームから送信されたaddress（住所）をユーザーのaddressプロパティに代入。
        $user->building = $request->input('building');
        $user->save();
        // 変更したユーザー情報をDBに保存。
        // これで住所情報が更新される。

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