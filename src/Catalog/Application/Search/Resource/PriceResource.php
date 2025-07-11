<?php

declare(strict_types=1);

namespace Challenge\Catalog\Application\Search\Resource;

readonly class PriceResource
{
    public function __construct(
        public int $original,
        public int $final,
        public ?string $discount_percentage = null,
        public string $currency,
    )
    {
    }
}
