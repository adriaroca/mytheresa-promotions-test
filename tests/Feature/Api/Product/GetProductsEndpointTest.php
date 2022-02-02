<?php

namespace Tests\Feature\Api\Product;

use App\Mappers\EloquentProductModelToDomainProduct;
use App\Models\Product;
use App\UseCases\Product\GetProductsByFiltersUseCase;
use Illuminate\Testing\Fluent\AssertableJson;
use Mockery\MockInterface;
use Tests\TestCase;

/**
 * @group product
 */
class GetProductsEndpointTest extends TestCase
{
    private $uri = '/api/products';
    private $responseJsonStructure = [
        'products' => [
            '*' => [
                'sku',
                'name',
                'category',
                'price' => [
                    'original',
                    'final',
                    'discount_percentage',
                    'currency',
                ],
            ]
        ]
    ];

    protected function setUp(): void
    {
        parent::setUp();
    }

    public function test_default()
    {
        $response = $this->get($this->uri);

        $response->assertStatus(200);
    }

    public function test_multiple_product_results_without_discount_by_category()
    {
        $testCategory = 'no-discount-category';
        $testProducts = Product::factory(3)->make([
            'category' => $testCategory,
        ]);

        $this->mock(GetProductsByFiltersUseCase::class, function (MockInterface $mock) use ($testProducts) {
            $mock->shouldReceive('__invoke')->andReturn(
                $testProducts->map(function ($testProduct) {
                    return EloquentProductModelToDomainProduct::transform($testProduct);
                })->toArray()
            )->once();
        });

        $response = $this->json('GET', $this->uri, [
            'category' => $testCategory,
        ]);

        $response->assertStatus(200);
        $response->assertJson(function (AssertableJson $json) {
            $json->has('products', 3, function ($json) {
                $json->where('category', 'no-discount-category')->etc();
            });
        });

        $response->assertJsonStructure($this->responseJsonStructure);
    }

    public function test_multiple_product_results_without_discount_and_without_filters()
    {
        $testProducts = Product::factory(4)->make();

        $this->mock(GetProductsByFiltersUseCase::class, function (MockInterface $mock) use ($testProducts) {
            $mock->shouldReceive('__invoke')->andReturn(
                $testProducts->map(function ($testProduct) {
                    return EloquentProductModelToDomainProduct::transform($testProduct);
                })->toArray()
            )->once();
        });

        $response = $this->json('GET', $this->uri);

        $response->assertStatus(200);
        $response->assertJson(function (AssertableJson $json) {
            $json->has('products', 4);
        });

        $response->assertJsonStructure($this->responseJsonStructure);
    }
}
