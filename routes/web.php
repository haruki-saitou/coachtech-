<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PurchaseController;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\CommentController;

Route::get('/', [ProductController::class, 'index'])->name('product.index');
Route::get('/item/{item_id}', [ProductController::class, 'show'])->name('product.show');

Route::middleware(['auth', 'verified'])->group(function () {
    //購入関連
    Route::get('/purchase/{item_id}', [PurchaseController::class, 'show'])->name('purchase.show');
    Route::get('/purchase/address/{item_id}', [PurchaseController::class, 'edit'])->name('purchase.edit');
    Route::patch('/purchase/address/{item_id}', [PurchaseController::class, 'update'])->name('purchase.update');
    Route::post('/purchase/checkout/{item_id}', [PurchaseController::class, 'checkout'])->name('purchase.checkout');
    Route::get('/purchase/success/{item_id}', [PurchaseController::class, 'success'])->name('purchase.success');
    Route::get('/sell', [ProductController::class, 'create'])->name('product.create');
    Route::post('/sell', [ProductController::class, 'store'])->name('product.store');
    Route::get('/mypage', [ProfileController::class, 'index'])->name('profile.index');
    Route::get('/mypage/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/mypage/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::post('/item/{item_id}/like', [LikeController::class, 'toggle'])->name('like.toggle');
    Route::post('/item/{item_id}/comment', [CommentController::class, 'store'])->name('comment.store');
});