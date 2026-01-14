<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PurchaseController;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\StripeWebhookController;

// -- 外部サービス連携(認証不要) --
Route::post('/stripe/webhook', [StripeWebhookController::class, 'handle'])->name('stripe.webhook');
// -- 商品閲覧(公開ページ) --
Route::get('/', [ProductController::class, 'topProduct'])->name('product.index');
Route::get('/item/{item_id}', [ProductController::class, 'showProduct'])->name('product.show');
// -- 認証必要機能 --
Route::middleware(['auth', 'verified'])->group(function () {
    //購入関連
    Route::get('/purchase/{item_id}', [PurchaseController::class, 'showPurchase'])->name('purchase.show');
    Route::get('/purchase/address/{item_id}', [PurchaseController::class, 'editAddress'])->name('purchase.edit');
    Route::patch('/purchase/address/{item_id}', [PurchaseController::class, 'updateAddress'])->name('purchase.update');
    Route::post('/purchase/checkout/{item_id}', [PurchaseController::class, 'checkout'])->name('purchase.checkout');
    Route::get('/purchase/success/{item_id}', [PurchaseController::class, 'success'])->name('purchase.success');
    //出品関連
    Route::get('/sell', [ProductController::class, 'createProduct'])->name('product.create');
    Route::post('/sell', [ProductController::class, 'storeProduct'])->name('product.store');
    //マイページ
    Route::get('/mypage', [ProfileController::class, 'topProfile'])->name('profile.index');
    Route::get('/mypage/profile', [ProfileController::class, 'editProfile'])->name('profile.edit');
    Route::patch('/mypage/profile', [ProfileController::class, 'updateProfile'])->name('profile.update');
    //お気に入り
    Route::post('/item/{item_id}/like', [LikeController::class, 'toggle'])->name('like.toggle');
    //コメント
    Route::post('/item/{item_id}/comment', [CommentController::class, 'storeComment'])->name('comment.store');
});
