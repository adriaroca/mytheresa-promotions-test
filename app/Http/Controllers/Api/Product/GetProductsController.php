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
        $applyDiscount = $request->boolean('discount', true);

        $productFilters = new ProductFilters();
        $productFilters->setCategory($category);
        $productFilters->setApplyDiscount($applyDiscount);

        $products = $getProductsByFiltersUseCase->__invoke($productFilters, config('api.product.list.max_results'));

        return response()->json([
            'products' => collect($products)->map(function (Product $product) {
                return $product->toArray();
            }),
        ]);
    }
}
