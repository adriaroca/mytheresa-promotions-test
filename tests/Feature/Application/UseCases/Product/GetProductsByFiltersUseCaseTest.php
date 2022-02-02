<?php

namespace Tests\Feature\Application\UseCases\Product;

use App\Domain\Values\ProductFilters;
use App\Models\Product;
use App\UseCases\Product\GetProductsByFiltersUseCase;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\Feature\Application\UseCases\UseCaseBaseTest;

/**
 * @group product
 */
class GetProductsByFiltersUseCaseTest extends UseCaseBaseTest
{

    protected function useCase(): string
    {
        return GetProductsByFiltersUseCase::class;
    }

    public function test_multiple_product_results_without_discount_by_category()
    {
        $testCategory = 'no-discount-category';
        Product::factory(3)->create([
            'category' => $testCategory,
        ]);

        Product::factory(3)->create([
            'category' => 'another-category',
        ]);

        $productFilters = new ProductFilters();
        $productFilters->setCategory($testCategory);
        $products = $this->invokeUseCase($productFilters);

        $this->assertIsArray($products);
        $this->assertCount(3, $products);
        $this->assertInstanceOf(\App\Domain\Entities\Product::class, $products[0]);
    }

    public function test_multiple_product_results_without_discount_and_without_filters()
    {
        Product::factory(4)->create();

        $productFilters = new ProductFilters();
        $products = $this->invokeUseCase($productFilters);

        $this->assertIsArray($products);
        $this->assertCount(4, $products);
        $this->assertInstanceOf(\App\Domain\Entities\Product::class, $products[0]);
    }

}
