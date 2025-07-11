<?php

declare(strict_types=1);

namespace Challenge\Catalog\Domain\Repository;

use Challenge\Catalog\Domain\Model\Product;

interface ProductRepository
{
    /**
     * @return Product[]
     */
    public function searchByCriteria(ProductCriteria $criteria): array;
}
