<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use App\Models\Product;

class ProfileController extends Controller
{
    public function topProfile(Request $request, $user_id = null)
    {
        $user = Auth::user();
        $tab = $request->input('page');
        $query = Product::query();

        // マイページ出品・購入した商品を表示
        if ($tab === 'buy'){
            // 購入した商品
            $query->whereHas('orders', function ($q) use ($user) {
                $q->where('user_id', $user->id);
            });
        } else {
            // 出品した商品
            $query->where('user_id', $user->id);
        }
        $products = $query->get();
        $is_empty = $products->isEmpty();

        return view('profiles.index', compact('user', 'products', 'is_empty'));
    }

    public function editProfile()
    {
        $user = Auth::user();
        return view('profiles.edit', compact('user'));
    }

    public function updateProfile(ProfileRequest $request)
    {
        $user = Auth::user();

        $data = $request->all();

        if ($request->hasFile('image_path')) {
            if ($user->image_path) {
                Storage::delete($user->image_path);
            }
            $file = $request->file('image_path');
            $data['image_path'] = $file->store('profile_images', 'public');
        }

        $user->update($data);

        return redirect()->route('product.index')->with('status', 'プロフィールを更新しました。');
    }
}