<?php

declare(strict_types=1);

namespace Challenge\Tests\Catalog\Domain\Model;

use Challenge\Tests\Catalog\MotherObject\PriceMother;
use PHPUnit\Framework\TestCase;

final class PriceTest extends TestCase
{
    public function testAppliedPriceDiscount(): void
    {
        $price = PriceMother::create();
        $result = $price->applyDiscount(25.0);

        $this->assertEquals(66750, $result->amount);
    }
}