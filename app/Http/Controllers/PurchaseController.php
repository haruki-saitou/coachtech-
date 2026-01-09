<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use App\Http\Requests\PurchaseRequest;
use Illuminate\Support\Facades\Auth;
use Stripe\Stripe;
use Stripe\Checkout\Session;
use App\Http\Requests\UpdateAddressRequest;
use Illuminate\Http\Request;

class PurchaseController extends Controller
{
    public function show($item_id)
    {
        $product = Product::findOrFail($item_id);
        $user = Auth::user();
        return view('purchases.show', compact('product', 'user'));
    }

    public function edit(Request $request, $item_id)
    {
        if ($request->has('payment_method')) {
            session(['payment_method' => $request->payment_method]);
        }
        $user = Auth::user();
        return view('purchases.edit', compact('user', 'item_id'));
    }

    public function update(UpdateAddressRequest $request)
    {
        $user = Auth::user();
        $user->update([
            'post_code' => $request->post_code,
            'address' => $request->address,
            'building' => $request->building,
        ]);

        if (session()->has('payment_method')) {
            session()->flash('payment_method', session('payment_method'));
        }

        return redirect()->route('purchase.show', ['item_id' => $request->item_id])->with('status', '配送先情報を更新しました。');
    }

    public function checkout(PurchaseRequest $request, $item_id) {
        $product = Product::findOrFail($item_id);
        Stripe::setApiKey(config('services.stripe.secret') ?? env('STRIPE_SECRET'));

        $session = Session::create([
            'payment_method_types' => [$request->payment_method === 'card' ? 'card' : 'konbini'],
            'line_items' => [[
                'price_data' => [
                    'currency' => 'jpy',
                    'product_data' => [
                        'name' => $product->name,
                    ],
                    'unit_amount' => $product->price,
                ],
                'quantity' => 1,
            ]],
            'mode' => 'payment',
            'success_url' => route('purchase.success', ['item_id' => $product->id]),
            'cancel_url' => route('purchase.show', ['item_id' => $product->id, 'status' => 'cancel']),
        ]);

        return redirect()->away($session->url);
    }

    public function success($item_id) {
        $user = Auth::user();
        $product = Product::findOrFail($item_id);
        Order::create([
            'user_id' => $user->id,
            'product_id' => $product->id,
            'payment_method' => 'stripe',
        ]);
        $product->update(['is_sold' => true]);
        return redirect()->route('product.index')->with('status', '商品を購入しました');
    }
}