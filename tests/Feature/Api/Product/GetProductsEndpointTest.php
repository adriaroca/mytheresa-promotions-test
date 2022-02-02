<?php

namespace Tests\Feature\Api\Product;

use App\Models\Product;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\TestCase;

/**
 * @group product
 */
class GetProductsEndpointTest extends TestCase
{
    private $uri = '/api/products';

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
        Product::factory(3)->create([
            'category' => $testCategory,
        ]);

        Product::factory(3)->create([
            'category' => 'another-category',
        ]);

        $response = $this->json('GET', $this->uri, [
            'category' => $testCategory,
        ]);

        $response->assertStatus(200);
        $response->assertJson(function (AssertableJson $json) {
            $json->has('products', 3, fn ($json) =>
                $json->where('category', 'no-discount-category')
                    ->etc()
            );
        });
    }

    public function test_multiple_product_results_without_discount_and_without_filters()
    {
        Product::factory(4)->create();

        $response = $this->json('GET', $this->uri);

        $response->assertStatus(200);
        $response->assertJson(function (AssertableJson $json) {
            $json->has('products', 4);
        });
    }
}
