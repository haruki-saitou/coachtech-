<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\CommentRequest;

class CommentController extends Controller
{
    public function storeComment(CommentRequest $request, $item_id)
    {
        Comment::create([
            'user_id' => Auth::id(),
            'product_id' => $item_id,
            'comment' => $request->comment,
        ]);

        return back();
    }
}