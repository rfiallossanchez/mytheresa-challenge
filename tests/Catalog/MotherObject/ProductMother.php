<?php

declare(strict_types=1);

namespace Challenge\Tests\Catalog\MotherObject;

use Challenge\Catalog\Domain\Model\Product;

final class ProductMother
{
    public static function createWithoutDiscount(): Product
    {
        return new Product(
            '000001',
            'BVLean leather ankle boots',
            'boots',
            PriceMother::create(),
        );
    }

    public static function createWithMultipleDiscount(): Product
    {
        return new Product(
            '000001',
            'BVLean leather ankle boots',
            'boots',
            PriceMother::create(),
            DiscountMother::createWithHighDiscount()
        );
    }

    /**
     * @return Product[]
     */
    public static function createMultiple(): array
    {
        $product1 = new Product(
            '000001',
            'BVLean leather ankle boots',
            'boots',
            PriceMother::create(),
            DiscountMother::createWithHighDiscount()
        );

        $product2 = new Product(
            '000002',
            'Nathane leather sneakers',
            'sneakers',
            PriceMother::create()
        );

        $product3 = new Product(
            '000003',
            'Naima embellished suede sandals',
            'sandals',
            PriceMother::create(),
            DiscountMother::createWithHighDiscount()
        );

        return [$product1, $product2, $product3];
    }
}