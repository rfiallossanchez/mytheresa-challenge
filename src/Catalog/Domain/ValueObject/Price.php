<?php

declare(strict_types=1);

namespace Challenge\Catalog\Domain\ValueObject;

readonly class Price
{
    private const string DEFAULT_CURRENCY = 'EUR';

    public function __construct(
        public int $amount,
        public string $currency = self::DEFAULT_CURRENCY
    )
    {
    }

    public function applyDiscount(float $percentage): Price
    {
        $discountedAmount = (int)round($this->amount * (1 - $percentage / 100));
        return new Price($discountedAmount, $this->currency);
    }
}
