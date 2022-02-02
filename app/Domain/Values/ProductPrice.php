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
        return [
            'original' => $this->getOriginal(),
            'final' => $this->getFinal(),
            'discount_percentage' => $this->getDiscountPercentage(),
            'currency' => $this->getCurrency(),
        ];
    }
}
