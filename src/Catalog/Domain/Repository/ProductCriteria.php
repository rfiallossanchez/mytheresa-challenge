<?php

declare(strict_types=1);

namespace Challenge\Catalog\Domain\Repository;

final readonly class ProductCriteria
{
    public function __construct(
        public ?string $category = null,
        public ?int $priceLessThan = null,
        public ?int $maxResults = 5
    )
    {
    }

    public static function create(
        ?string $category = null,
        ?int $priceLessThan = null,
    ): ProductCriteria
    {
        return new ProductCriteria($category, $priceLessThan);
    }
}
