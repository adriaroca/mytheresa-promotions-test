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
    public function all(int $limit = null): array
    {

        if($limit) {
            $modelProducts = $this->model->limit($limit)->get();
        } else {
            $modelProducts = $this->model->all();
        }

        return $modelProducts->map(function (ModelProduct $modelProduct) {
            return EloquentProductModelToDomainProduct::transform($modelProduct);
        })->toArray();
    }

    /**
     * @return array<int, DomainProduct>
     */
    public function getByCategory(string $category, int $limit = null): array
    {
        $modelProducts = $this->model->where('category', $category);
        if($limit) {
            $modelProducts = $modelProducts->limit($limit);
        }

        return $modelProducts->get()->map(function (ModelProduct $modelProduct) {
            return EloquentProductModelToDomainProduct::transform($modelProduct);
        })->toArray();
    }
}
