<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class ProductController extends Controller
{
    public function index()
    {

        if (Cache::has('products')) {
            return response()->json([
                'from_cache' => true,
                'data' => Cache::get('products')
            ]);
        }

        $products = Cache::remember('products', 60, function () {
            return Product::all();
        });

        return response()->json([
            'from_cache' => false,
            'data' => $products
        ]);
    }

    public function store(Request $request)
    {
        $product = Product::create($request->all());

        Cache::forget('products');

        return response()->json($product, 201);
    }
}