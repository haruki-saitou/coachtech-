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

            Order::create([
                'user_id' => $userId,
                'product_id' => $productId,
                'payment_method' => $session['metadata']['payment_method'],
            ]);

            $product = Product::find($productId);
            if ($product) {
                $product->update(['is_sold' => true]);
            }
            Log::info("決済完了処理を実行しました。商品ID: {$productId}, ユーザーID: {$userId}");
        }

        return response('webhook Handled', 200);
    }
}
