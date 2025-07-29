<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Item;

class MypageController extends Controller
{
    // マイページトップ（自分の出品一覧表示など）
    public function index()
    {
        // ログインユーザーの出品商品一覧を取得
        $user = Auth::user();  //Auth::user()で「現在ログインしているユーザー情報」を取得します。$userという変数にそのユーザー情報を格納。
        $items = $user->items()->latest()->get();
        //$user->items()で「そのユーザーが出品した商品一覧（リレーション）」を取得。
        //latest()で新しい順に並べる。
        //get()で「コレクション」としてデータを全部取得。
        return view('mypage.index', compact('items'));
        //compact('items')で、Bladeファイルに「$items変数」を渡す。
    }

    // プロフィール編集画面表示
    public function editProfile()
    {
        $user = Auth::user();
        return view('mypage.profile', compact('user'));
    }

    // プロフィール更新処理
    public function updateProfile(Request $request)
    {
        $user = Auth::user();

        // バリデーション（最低限例。項目は適宜追加）
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            // 他プロフィール項目があればここに
        ]);

        $user->update($validated);

        return redirect()->route('mypage.index')->with('success', 'プロフィールを更新しました');
    }

}
