<?php

declare(strict_types=1);

namespace Challenge\Tests\Catalog\Domain\Model;

use Challenge\Tests\Catalog\MotherObject\ProductMother;
use PHPUnit\Framework\TestCase;

final class ProductTest extends TestCase
{
    public function testProductWithoutDiscountHasOriginalPrice(): void
    {
        $product = ProductMother::createWithoutDiscount();

        $this->assertEmpty($product->discounts());
        $this->assertNull($product->discountedPercentage());
        $this->assertEquals(
            $product->originalPrice()->amount,
            $product->calculateFinalPrice()->amount
        );
    }

    public function testProductWithMultipleDiscountsBiggerIsApplied(): void
    {

        $product = ProductMother::createWithMultipleDiscount();

        $this->assertNotEmpty($product->discounts());
        $this->assertNotEquals(
            $product->originalPrice()->amount,
            $product->calculateFinalPrice()->amount
        );

        $this->assertEquals('25%', $product->discountedPercentage());
        $this->assertEquals('66750', $product->calculateFinalPrice()->amount);
    }
}
