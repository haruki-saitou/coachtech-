<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Order;
use Illuminate\Support\Facades\Log;

class StripeWebhookController extends Controller
{
    public function handle(Request $request) {
        $payload = $request->all();

        if ($payload['type'] === 'checkout.session.completed') {
            $session = $payload['data']['object'];
            $productId = $session['metadata']['product_id'];
            $userId = $session['metadata']['user_id'];
            $paymentMethod = $session['metadata']['payment_method'];

            $product = Product::find($productId);
            if ($product && !$product->is_sold) {
                Order::create([
                'user_id' => $userId,
                'product_id' => $productId,
                'payment_method' => $paymentMethod,
                'post_code' => $session['metadata']['post_code'],
                'address' => $session['metadata']['address'],
                'building' => $session['metadata']['building'],
                ]);
                $product->update(['is_sold' => true]);
                Log::info("【決済完了】商品ID: {$productId}, ユーザーID: {$userId} の注文を受け付けました。");
            } else {
                Log::error("【処理失敗】商品ID: {$productId}はすでに売却済みか、存在しません。");
            }
        }

        return response('webhook Handled', 200);
    }
}
