<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Events\ProductUpdated;

class ProductController extends Controller
{
    public function fetchProducts()
    {
        $response = Http::get('https://fakestoreapi.com/products');
        $products = $response->json();

        foreach ($products as $productData) {
            $product = Product::updateOrCreate(
                ['name' => $productData['title']],
                [
                    'description' => $productData['description'],
                    'price' => $productData['price']
                ]
            );
        }

        event(new ProductUpdated());

        return response()->json(['message' => 'Products fetched successfully']);
    }

    public function index()
    {
        $products = Product::latest()->get();
        return view('products.index', compact('products'));
    }
}