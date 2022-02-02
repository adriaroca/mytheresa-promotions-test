<?php
/**
 * Author: adriaroca
 * Date: 2/2/22 1:16
 */

namespace App\Repositories;

use App\Domain\Repositories\ProductRepository;
use App\Mappers\EloquentProductModelToDomainProduct;
use App\Models\Product as ModelProduct;
use App\Domain\Entities\Product as DomainProduct;

class EloquentProductRepository extends EloquentBaseRepository implements ProductRepository
{

    public function model(): string
    {
        return ModelProduct::class;
    }

    /**
     * @return array<int, DomainProduct>
     */
    public function all(): array
    {
        $modelProducts = $this->model->all();
        return $modelProducts->map(function (ModelProduct $modelProduct) {
            return EloquentProductModelToDomainProduct::transform($modelProduct);
        })->toArray();
    }

    /**
     * @return array<int, DomainProduct>
     */
    public function getByCategory(string $category): array
    {
        $modelProducts = $this->model->where('category', $category)->get();
        return $modelProducts->map(function (ModelProduct $modelProduct) {
            return EloquentProductModelToDomainProduct::transform($modelProduct);
        })->toArray();
    }
}
