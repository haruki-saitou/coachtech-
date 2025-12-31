<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PurchaseController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\CommentController;


// Route::get('/login', [AuthController::class, 'login'])->name('login');
// Route::get('/register', [AuthController::class, 'register'])->name('register');
Route::get('/', [ProductController::class, 'index'])->name('product.index');
Route::get('/products/{product_id}', [ProductController::class, 'show'])->name('product.show');

Route::middleware('auth')->group(function () {
    //購入関連
    Route::get('/purchases/{purchase_id}', [PurchaseController::class, 'show'])->name('purchase.show');
    Route::get('/purchases/address/{purchase_id}', [PurchaseController::class, 'edit'])->name('purchase.edit');
    //商品出品関連
    Route::get('/sell', [ProductController::class, 'create'])->name('product.create');
    //プロフィール関連
    Route::get('/mypage', [ProfileController::class, 'index'])->name('profile.index');
    Route::get('/mypage/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    //いいね機能
    Route::post('/products/{product_id}/like', [LikeController::class, 'toggle'])->name('like.toggle');
    //コメント機能
    Route::post('/products/{product_id}/comment', [CommentController::class, 'store'])->name('comment.store');
});
