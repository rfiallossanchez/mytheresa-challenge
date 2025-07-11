<?php

declare(strict_types=1);

namespace Challenge\Catalog\Application\Search;

use Symfony\Component\Validator\Constraints as Assert;

final class SearchProductQuery
{
    #[Assert\Type('string')]
    public ?string $category = null;

    #[Assert\Type('integer')]
    #[Assert\Positive]
    public ?int $priceLessThan = null;
}
