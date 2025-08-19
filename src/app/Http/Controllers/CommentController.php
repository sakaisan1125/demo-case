<?php

namespace App\Http\Controllers;

use App\Http\Requests\CommentRequest; // ✅ 追加
use App\Models\Comment;
use App\Models\Item;

class CommentController extends Controller
{
    public function store(CommentRequest $request, Item $item) // ✅ 変更
    {
        // ✅ バリデーションは自動実行される
        
        Comment::create([
            'user_id' => auth()->id(),
            'item_id' => $item->id,
            'content' => $request->input('content'),
        ]);

        return back()->with('success', 'コメントを投稿しました');
    }
}