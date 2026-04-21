<?php

namespace App\Http\Controllers;

use App\Models\Product;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::where('is_active', true)->orderBy('category')->orderBy('name')->get();
        $grouped = $products->groupBy('category');

        return view('store.index', compact('grouped'));
    }

    public function show(Product $product)
    {
        abort_unless($product->is_active, 404);

        return view('store.show', compact('product'));
    }
}
