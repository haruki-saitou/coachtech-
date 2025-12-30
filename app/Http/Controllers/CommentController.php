<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Comment;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\CommentRequest;

class CommentController extends Controller
{
    public function store(CommentRequest $request, $product_id)
    {
        Comment::create([
            'user_id' => Auth::id(),
            'product_id' => $product_id,
            'comment' => $request->comment,
        ]);

        return back();
    }
}