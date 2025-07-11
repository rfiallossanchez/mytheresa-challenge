<?php

declare(strict_types=1);

namespace Challenge\Tests\Catalog\MotherObject;

use Challenge\Catalog\Domain\ValueObject\Price;

final class PriceMother
{
    public static function create(): Price
    {
        return new Price(89000);
    }
}