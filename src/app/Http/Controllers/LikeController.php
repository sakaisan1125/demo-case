<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Item;
use App\Models\Like;
use Illuminate\Support\Facades\Auth;

class LikeController extends Controller
{
    // いいね
    public function store(Item $item)
    {
        $user = Auth::user();
        // すでにいいねしていたら何もしない
        if (!$user->likes()->where('item_id', $item->id)->exists()) {
            $user->likes()->create(['item_id' => $item->id]);
        }
        return back();
    }

    // いいね解除
    public function destroy(Item $item)
    {
        $user = Auth::user();
        $like = $user->likes()->where('item_id', $item->id)->first();
        if ($like) {
            $like->delete();
        }
        return back();
    }
}
