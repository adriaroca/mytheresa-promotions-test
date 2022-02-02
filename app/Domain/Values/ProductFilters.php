<?php

namespace App\Domain\Values;

/**
 * Author: adriaroca
 * Date: 2/2/22 1:22
 */
class ProductFilters
{
    private $category;

    /**
     * @return null|string
     */
    public function getCategory(): ?string
    {
        return $this->category;
    }

    /**
     * @param null|string $category
     */
    public function setCategory(?string $category): void
    {
        $this->category = $category;
    }

}
