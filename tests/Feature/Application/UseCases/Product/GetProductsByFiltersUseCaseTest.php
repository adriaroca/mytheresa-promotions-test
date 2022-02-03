<?php

namespace Tests\Feature\Application\UseCases\Product;

use App\Domain\Values\ProductFilters;
use App\Models\Product;
use App\UseCases\Product\GetProductsByFiltersUseCase;
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

    public function test_max_results_without_discount_by_category()
    {
        $testCategory = 'no-discount-category';
        Product::factory(20)->create([
            'category' => 'no-discount-category',
        ]);

        $productFilters = new ProductFilters();
        $productFilters->setCategory($testCategory);
        $products = $this->invokeUseCase($productFilters, 5);

        $this->assertIsArray($products);
        $this->assertCount(5, $products);
    }

    public function test_max_results_without_discount_and_without_filters()
    {
        Product::factory(12)->create();

        $productFilters = new ProductFilters();
        $products = $this->invokeUseCase($productFilters, 6);

        $this->assertIsArray($products);
        $this->assertCount(6, $products);
    }

    public function test_results_applying_discount()
    {
        Product::factory()->create([
            'price' => 89000,
            'category' => 'boots', //category with discount
        ]);

        $productFilters = new ProductFilters();
        $productFilters->setApplyDiscount(true);

        $products = $this->invokeUseCase($productFilters, 1);

        $this->assertIsArray($products);
        $this->assertNotEquals($products[0]->getPrice()->getOriginal(), $products[0]->getPrice()->getFinal());
    }

    public function test_results_without_applying_discount()
    {
        Product::factory(1)->create([
            'category' => 'boots', //category with discount
        ]);

        $productFilters = new ProductFilters();
        $productFilters->setApplyDiscount(false);

        $products = $this->invokeUseCase($productFilters, 1);

        $this->assertEquals($products[0]->getPrice()->getOriginal(), $products[0]->getPrice()->getFinal());
    }

}
