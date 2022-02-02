<?php

namespace Tests\Feature\Domain\Values;

use App\Domain\Values\ProductPrice;
use Tests\TestCase;

/**
 * @group product
 */
class ProductPriceTest extends TestCase
{
    public function test_from_product_with_sku_discount()
    {
        $productPrice = ProductPrice::fromProduct('000003', 'random-category', 89000);
        $this->assertEquals(new ProductPrice(89000, 75650, 15, 'EUR'), $productPrice);
    }

    public function test_from_product_with_category_discount()
    {
        $productPrice = ProductPrice::fromProduct('000001', 'boots', 89000);
        $this->assertEquals(new ProductPrice(89000, 62300, 30, 'EUR'), $productPrice);
    }

    public function test_from_product_with_category_and_sky_discount()
    {
        $productPrice = ProductPrice::fromProduct('000003', 'boots', 89000);
        $this->assertEquals(new ProductPrice(89000, 62300, 30, 'EUR'), $productPrice);
    }

    public function test_from_product_without_discount()
    {
        $productPrice = ProductPrice::fromProduct('000001', 'random-category', 89000);
        $this->assertEquals(new ProductPrice(89000, 89000, null, 'EUR'), $productPrice);
    }
}
