<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;



class ProductController extends Controller
{
    public function index()
    {
        $userId = \Illuminate\Support\Facades\Auth::id();
        $products = Product::where('user_id', '!=',  $userId)->get();
        return view('products.index', compact('products'));
    }

    public function show($product_id)
    {
        $product = Product::findOrFail($product_id);
        return view('products.show', compact('product'));
    }
    public function create()
    {
        return view('products.create');
    }
}