<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\ProductRequest;



class ProductController extends Controller
{
    public function index(Request $request)
    {
        if ($request->query('tab') === 'mylist' && !Auth::check()) {
            return redirect()->route('login');
        }

        $query = Product::query();
        if (Auth::check()) {
            $query->where('user_id', '!=', Auth::id());
            if ($request->query('tab') === 'mylist') {
                $query->whereHas('likes', function ($q) {
                    $q->where('user_id', Auth::id());
                });
            }
        }
        $products = $query->get();
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
