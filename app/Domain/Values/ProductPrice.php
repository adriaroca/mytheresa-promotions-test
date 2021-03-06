<?php
/**
 * Author: adriaroca
 * Date: 2/2/22 19:40
 */

namespace App\Domain\Values;

class ProductPrice
{
    /**
     * @var int
     */
    private $original;
    /**
     * @var int
     */
    private $final;
    /**
     * @var int
     */
    private $discountPercentage;
    /**
     * @var string
     */
    private $currency;

    public function __construct(
        int $original,
        int $final,
        int $discountPercentage = null,
        string $currency = 'EUR'
    )
    {
        $this->original = $original;
        $this->final = $final;
        $this->discountPercentage = $discountPercentage;
        $this->currency = $currency;
    }

    public static function fromProduct(string $sku, string $category, int $price, bool $applyDiscount = true): self
    {
        if($applyDiscount === false) {
            return new ProductPrice($price, $price);
        }

        $skuWithDiscount = [
            '000003' => 15,
        ];

        $categoriesWithDiscount = [
            'boots' => 30,
        ];

        $skuDiscount = $skuWithDiscount[$sku] ?? null;
        $categoryDiscount = $categoriesWithDiscount[$category] ?? null;

        $discount = max($skuDiscount, $categoryDiscount);
        $finalPrice = $discount ? $price - ($price * ($discount/100)) : $price;

        return new self(
            $price,
            $finalPrice,
            $discount,
        );
    }

    /**
     * @return int
     */
    public function getOriginal(): int
    {
        return $this->original;
    }

    /**
     * @param int $original
     */
    public function setOriginal(int $original): void
    {
        $this->original = $original;
    }

    /**
     * @return int
     */
    public function getFinal(): int
    {
        return $this->final;
    }

    /**
     * @param int $final
     */
    public function setFinal(int $final): void
    {
        $this->final = $final;
    }

    /**
     * @return int
     */
    public function getDiscountPercentage(): ?int
    {
        return $this->discountPercentage;
    }

    /**
     * @param int $discountPercentage
     */
    public function setDiscountPercentage(int $discountPercentage): void
    {
        $this->discountPercentage = $discountPercentage;
    }

    /**
     * @return string
     */
    public function getCurrency(): string
    {
        return $this->currency;
    }

    /**
     * @param string $currency
     */
    public function setCurrency(string $currency): void
    {
        $this->currency = $currency;
    }

    public function toArray(): array
    {
        $discountPercentage = $this->getDiscountPercentage();

        return [
            'original' => $this->getOriginal(),
            'final' => $this->getFinal(),
            'discount_percentage' => !is_null($discountPercentage) ? $discountPercentage.'%' : null,
            'currency' => $this->getCurrency(),
        ];
    }
}
