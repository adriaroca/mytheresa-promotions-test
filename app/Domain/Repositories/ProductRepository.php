<?php

namespace App\Domain\Repositories;

/**
 * Author: adriaroca
 * Date: 2/2/22 1:17
 */
interface ProductRepository
{
    public function all(): array;
    public function getByCategory(string $category): array;
}
