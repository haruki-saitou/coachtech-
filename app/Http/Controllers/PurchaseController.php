<?php

namespace App\Http\Controllers;

use App\Models\Purchase;
use App\Models\Product;
use App\Http\Requests\PurchaseRequest;

class PurchaseController extends Controller
{
    public function show($purchase_id)
    {
        $product = Product::findOrFail($purchase_id);
        return view('purchases.show', compact('product'));
    }

    public function edit(PurchaseRequest $request, $purchase_id)
    {
        return view('purchases.edit', ['purchase_id' => $purchase_id]);
    }
}