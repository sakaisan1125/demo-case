<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Comment;
use App\Models\Item;

class CommentController extends Controller
{
    public function store(Request $request, Item $item)
    {
        $request->validate([
            'content' => 'required|string|max:255',
        ]);

        Comment::create([
            'user_id' => auth()->id(),
            'item_id' => $item->id,
            'content' => $request->input('content'),
        ]);

        return back()->with('success', 'コメントを投稿しました');
    }
}