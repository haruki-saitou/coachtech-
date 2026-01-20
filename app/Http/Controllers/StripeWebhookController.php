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
            $meta = $session['metadata'];

            $product = Product::find($meta['product_id'], ['*']);
            if ($product && !$product->is_sold) {
                Order::create([
                'user_id' => $meta['user_id'],
                'product_id' => $meta['product_id'],
                'payment_method' => $meta['payment_method'],
                'post_code' => $meta['post_code'],
                'address' => $meta['address'],
                'building' => $meta['building'],
                ]);
                $product->update(['is_sold' => true]);
                Log::info("【決済完了】商品ID: {$meta['product_id']}, ユーザーID: {$meta['user_id']} の注文を受け付けました。");
            } else {
                Log::error("【処理失敗】商品ID: {$meta['product_id']}はすでに売却済みか、存在しません。");
            }
        }

        return response('webhook Handled', 200);
    }
}
