<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PurchaseController extends Controller
{
    public function show($purchase_id)
    {
        return view('purchases.show', ['purchase_id' => $purchase_id]);
    }

    public function edit($purchase_id)
    {
        return view('purchases.edit', ['purchase_id' => $purchase_id]);
    }
}
