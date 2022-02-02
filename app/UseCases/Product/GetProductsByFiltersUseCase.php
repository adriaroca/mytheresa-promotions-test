<?php

namespace App\UseCases\Product;

use App\Domain\Entities\Product;
use App\Domain\Repositories\ProductRepository;
use App\Domain\Values\ProductFilters;

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
    public function __invoke(ProductFilters $productFilters): array
    {
        $category = $productFilters->getCategory();

        if ($category !== null) {
            $products = $this->productRepository->getByCategory($category);
        } else {
            $products = $this->productRepository->all();
        }

        return $products;
    }
}
