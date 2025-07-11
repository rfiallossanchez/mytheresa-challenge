<?php

declare(strict_types=1);

namespace Challenge\Tests\Catalog\MotherObject;

use Challenge\Catalog\Domain\Model\Discount;

final class DiscountMother
{
    /**
     * @return Discount[]
     */
    public static function createWithHighDiscount(): array
    {
        $lowDiscount = new Discount('low discount', 10);
        $highDiscount = new Discount('high discount', 25);

        return [$lowDiscount, $highDiscount];
    }

    /**
     * @return Discount[]
     */
    public static function createWithOnceDiscount(): array
    {
        $oneDiscount = new Discount('one discount', 10);

        return [$oneDiscount];
    }
}