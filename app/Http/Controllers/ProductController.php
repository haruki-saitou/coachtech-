<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\ProductRequest;
use App\Models\Category;
use App\Models\Condition;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $keyword = $request->query('keyword');
        $tab = $request->query('tab');

        $query = Product::query();

        if (!empty($keyword)) {
            $query->keywordSearch($keyword);
        }

        if ($tab === 'mylist') {
            if (!Auth::check()) {
                return redirect()->route('login');
            }
            $query->whereHas('likes', function ($q) {
                $q->where('user_id', Auth::id());
            });
        }else {
            if (Auth::check()) {
                $query->where('user_id', '!=', Auth::id());
            }
        }
        $products = $query->latest()->take(30)->get();
        $is_empty = $products->isEmpty();
        return view('products.index', compact('products', 'keyword', 'tab', 'is_empty'));
    }

    public function show($item_id)
    {
        $product = Product::findOrFail($item_id);
        return view('products.show', compact('product'));
    }
    public function create()
    {
        $categories = Category::all();
        $conditions = Condition::all();
        return view('products.create', compact('categories', 'conditions'));
    }

    public function store(ProductRequest $request)
    {
        $data = $request->validated();
        $data['image_path'] = $request->file('image_path')->store('images', 'public');
        $data['user_id'] = Auth::id();
        $product = Product::create($data);
        $product->categories()->sync($request->categories);
        return redirect()->route('product.show', $product->id);
    }
}
