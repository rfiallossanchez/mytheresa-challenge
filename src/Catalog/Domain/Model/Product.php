<?php

declare(strict_types=1);

namespace Challenge\Catalog\Domain\Model;

use Challenge\Catalog\Domain\ValueObject\Price;

readonly class Product
{
    /**
     * @param Discount[] $discounts
     */
    public function __construct(
        private string $sku,
        private string $name,
        private string $category,
        private Price $originalPrice,
        private array $discounts = [],
    )
    {
    }

    public function sku(): string
    {
        return $this->sku;
    }

    public function name(): string
    {
        return $this->name;
    }

    public function category(): string
    {
        return $this->category;
    }

    public function discounts(): array
    {
        return $this->discounts;
    }

    public function originalPrice(): Price
    {
        return $this->originalPrice;
    }

    private function findBestDiscount(): ?Discount
    {
        if (empty($this->discounts)) {
            return null;
        }

        return array_reduce($this->discounts, function (?Discount $best, Discount $current) {
            if ($best === null || $current->percentage() > $best->percentage()) {
                return $current;
            }
            return $best;
        });
    }

    public function calculateFinalPrice(): Price
    {
        $bestDiscount = $this->findBestDiscount();

        return $bestDiscount
            ? $this->originalPrice->applyDiscount($bestDiscount->percentage())
            : $this->originalPrice;
    }

    public function discountedPercentage(): ?string
    {
        $discount = $this->findBestDiscount();

        return $discount
            ? $discount->percentage() . '%'
            : null;
    }
}
