<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Like;
use Illuminate\Support\Facades\Auth;
class LikeController extends Controller
{
    public function toggle($product_id)
    {
        $user_id = Auth::id();
        $like = Like::where('user_id', $user_id)->where('product_id', $product_id)->first();

        if ($like) {
            $like->delete();
        } else {
            Like::create([
                'user_id' => $user_id,
                'product_id' => $product_id,
            ]);
        }

        return back();
    }
}
