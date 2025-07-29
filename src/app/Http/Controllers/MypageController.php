<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Item;
use App\Http\Requests\ProfileRequest;

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
    public function updateProfile(ProfileRequest $request)
    {
        $user = Auth::user(); // 現在ログイン中のユーザーを取得

        $data = $request->validated(); // ProfileRequestでバリデーション済みのデータを取得

        // 画像アップロード
        if ($request->hasFile('profile_image')) { // 画像がアップロードされているか確認
            // 古い画像がある場合は削除
            if ($user->profile_image && \Storage::disk('public')->exists($user->profile_image)) {
                \Storage::disk('public')->delete($user->profile_image); // 古い画像ファイルを削除
            }
            $path = $request->file('profile_image')->store('profiles', 'public'); // 新しい画像を保存
            $data['profile_image'] = $path; // 保存先パスを$dataにセット
        } else {
            // 画像未選択ならprofile_imageは更新しない
            unset($data['profile_image']); // profile_imageキーを削除し、既存画像を保持
        }

        $user->update($data); // ユーザー情報を更新

        return redirect()->route('mypage.index')->with('success', 'プロフィールを更新しました');
        // マイページにリダイレクトし、成功メッセージを表示
    }

}
