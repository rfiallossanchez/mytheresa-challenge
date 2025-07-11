<?php

declare(strict_types=1);

namespace Challenge\Catalog\Domain\Model;

readonly class Discount
{
    public function __construct(
        private string $id,
        private float $percentage,
    )
    {
    }

    public function id(): string
    {
        return $this->id;
    }

    public function percentage(): float
    {
        return $this->percentage;
    }
}
