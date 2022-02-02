<?php

namespace App\Domain\Entities;

use App\Domain\Values\ProductPrice;

/**
 * Author: adriaroca
 * Date: 2/2/22 19:23
 */
class Product
{
    /**
     * @var string
     */
    private $sku;
    /**
     * @var string
     */
    private $name;
    /**
     * @var string
     */
    private $category;
    /**
     * @var ProductPrice
     */
    private $price;

    public function __construct(
        string $sku,
        string $name,
        string $category,
        int $price
    )
    {
        $this->sku = $sku;
        $this->name = $name;
        $this->category = $category;
        $this->price = ProductPrice::fromProduct($sku, $category, $price);
    }

    /**
     * @return string
     */
    public function getSku(): string
    {
        return $this->sku;
    }

    /**
     * @param string $sku
     */
    public function setSku(string $sku): void
    {
        $this->sku = $sku;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName(string $name): void
    {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getCategory(): string
    {
        return $this->category;
    }

    /**
     * @param string $category
     */
    public function setCategory(string $category): void
    {
        $this->category = $category;
    }

    /**
     * @return ProductPrice
     */
    public function getPrice(): ProductPrice
    {
        return $this->price;
    }

    /**
     * @param ProductPrice $price
     */
    public function setPrice(ProductPrice $price): void
    {
        $this->price = $price;
    }

    public function toArray(): array
    {
        $productArray = get_object_vars($this);
        if(isset($productArray['price']) && is_a($productArray['price'], ProductPrice::class)) {
            $productArray['price'] = $productArray['price']->toArray();
        }

        return $productArray;
    }
}
