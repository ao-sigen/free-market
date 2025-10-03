<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Comment;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    public function store(Request $request, $id)
    {
        $request->validate([
            'comment' => 'required|string|max:500',
        ]);

        $product = Product::findOrFail($id);

        Comment::create([
            'product_id' => $product->id,
            'user_id' => Auth::id(),
            'text' => $request->comment,
        ]);

        return redirect()->back()->with('success', 'コメントを投稿しました');
    }
}
