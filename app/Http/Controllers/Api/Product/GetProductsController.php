<?php

namespace App\Http\Controllers\Api\Product;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class GetProductsController extends Controller
{
    public function __invoke(Request $request)
    {
        $category = $request->get('category');

        if ($category !== null) {
            $products = Product::where('category', $category)->get();
        } else {
            $products = Product::all();
        }

        $products = $products->map(function ($product) {
            return [
                'sku' => $product->sku,
                'name' => $product->name,
                'category' => $product->category,
                'price' => [
                    'original' => $product->price,
                    'final' => $product->price,
                    'discount_percentage' => null,
                    'currency' => 'EUR'
                ]
            ];
        });

        return response()->json([
            'products' => $products->toArray(),
        ]);
    }
}
