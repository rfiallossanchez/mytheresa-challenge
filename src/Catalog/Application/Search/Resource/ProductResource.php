<?php

declare(strict_types=1);

namespace Challenge\Catalog\Application\Search\Resource;

readonly class ProductResource
{
    public function __construct(
        public string $sku,
        public string $name,
        public string $category,
        public PriceResource $price,
    )
    {
    }
}
