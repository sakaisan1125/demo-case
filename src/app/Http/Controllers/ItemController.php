<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Item;
use App\Models\Like;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\ExhibitionRequest;


class ItemController extends Controller
{
    public function index(Request $request)
    {
    $tab = $request->query('tab');

    if ($tab === 'mylist') {
        if (auth()->check()) {
            // いいねした商品のみ
            $items = Item::whereIn('id', Like::where('user_id', auth()->id())->pluck('item_id'))->get();
        } else {
            // 未認証なら空
            $items = collect();
        }
    } else {
        $items = Item::all();
    }

    return view('items.index', compact('items', 'tab'));
    }

    public function show($id)
    {
        $item = \App\Models\Item::findOrFail($id);
        return view('items.show', compact('item'));
    }

    // 商品出品画面表示
    public function create()
    {
        // カテゴリー一覧も取得して渡す（多対多用）
        $categories = \App\Models\Category::all();
        return view('items.create', compact('categories'));
    }

    // 商品登録
    public function store(ExhibitionRequest $request)
    {
        // バリデーション済みデータ取得
        $validated = $request->validated();

        // 画像がアップロードされていれば保存
        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('items', 'public');
            $validated['image_path'] = $path;
        }

        // ログインユーザーを出品者として紐づけ
        $validated['user_id'] = Auth::id();

        // Item作成
        $item = Item::create($validated);

        // カテゴリー（多対多）
        if ($request->has('category_id')) {
            $item->categories()->sync($request->input('category_id')); // 配列で送る
        }

        return redirect()->route('items.index')->with('success', '商品を出品しました！');
    }

    public function like(Item $item)
    {
        $user = auth()->user();
        if (!$user->likes()->where('item_id', $item->id)->exists()) {
            $user->likes()->create(['item_id' => $item->id]);
        }
        return back();
    }

    public function unlike(Item $item)
    {
        $user = auth()->user();
        $user->likes()->where('item_id', $item->id)->delete();
        return back();
    }





}
