<?php

namespace App\Mappers;

use App\Domain\Values\ProductPrice;
use App\Models\Product as ModelProduct;
use App\Domain\Entities\Product as DomainProduct;

/**
 * Author: adriaroca
 * Date: 2/2/22 19:57
 */
class EloquentProductModelToDomainProduct
{
    public static function transform(ModelProduct $modelProduct): DomainProduct
    {
        return new DomainProduct(
            $modelProduct->sku,
            $modelProduct->name,
            $modelProduct->category,
            $modelProduct->price
        );
    }
}
