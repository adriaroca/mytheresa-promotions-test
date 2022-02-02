<?php

namespace App\Http\Controllers\Api\Product;

use App\Domain\Entities\Product;
use App\Domain\Values\ProductFilters;
use App\Http\Controllers\Controller;
use App\UseCases\Product\GetProductsByFiltersUseCase;
use Illuminate\Http\Request;

class GetProductsController extends Controller
{
    public function __invoke(Request $request, GetProductsByFiltersUseCase $getProductsByFiltersUseCase)
    {
        $category = $request->get('category');

        $productFilters = new ProductFilters();
        $productFilters->setCategory($category);

        $products = $getProductsByFiltersUseCase->__invoke($productFilters);

        return response()->json([
            'products' => collect($products)->map(function (Product $product) {
                return $product->toArray();
            }),
        ]);
    }
}
