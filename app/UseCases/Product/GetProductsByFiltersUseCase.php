<?php

namespace App\UseCases\Product;

use App\Domain\Entities\Product;
use App\Domain\Repositories\ProductRepository;
use App\Domain\Values\ProductFilters;
use App\Domain\Values\ProductPrice;

/**
 * Author: adriaroca
 * Date: 2/2/22 1:21
 */
class GetProductsByFiltersUseCase
{
    private $productRepository;

    /**
     * @param ProductRepository $productRepository
     */
    public function __construct(
        ProductRepository $productRepository
    )
    {
        $this->productRepository = $productRepository;
    }

    /**
     * @param ProductFilters $productFilters
     * @return array<int,Product>
     */
    public function __invoke(ProductFilters $productFilters, int $limit = null): array
    {
        $category = $productFilters->getCategory();
        $applyDiscount = $productFilters->applyDiscount();

        if ($category !== null) {
            $products = $this->productRepository->getByCategory($category, $limit);
        } else {
            $products = $this->productRepository->all($limit);
        }

        if($applyDiscount) {
            $products = collect($products)->map(function (Product $product) {
                $currentProductPrice = $product->getPrice();
                $productPrice = ProductPrice::fromProduct($product->getSku(), $product->getCategory(), $currentProductPrice->getOriginal());
                $product->setPrice($productPrice);
                return $product;
            })->toArray();
        }

        return $products;
    }
}
