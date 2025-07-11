<?php

declare(strict_types=1);

namespace Challenge\Catalog\Infrastructure\Doctrine\Mapper;

use Challenge\Catalog\Domain\Model\Discount;
use Challenge\Catalog\Domain\Model\Product;
use Challenge\Catalog\Domain\ValueObject\Price;
use Challenge\Catalog\Infrastructure\Doctrine\Entity\ProductEntity;

class ProductMapper
{
    public static function toDomain(ProductEntity $entity): Product
    {
        $discounts = [];
        foreach ([...$entity->productDiscounts, ...$entity->category->discounts] as $discount) {
            $discounts[] = new Discount(
                $discount->discount->id,
                $discount->discount->percentage
            );
        }


        return new Product(
            $entity->sku,
            $entity->name,
            $entity->category->name,
            new Price($entity->priceAmount, $entity->priceCurrency),
            $discounts
        );
    }
}
