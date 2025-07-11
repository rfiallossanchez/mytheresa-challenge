<?php

declare(strict_types=1);

namespace Challenge\Catalog\Infrastructure\Doctrine\Entity;

use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\Table(name: "category")]
class CategoryEntity
{
    #[ORM\Id]
    #[ORM\Column]
    public string $name;

    #[ORM\OneToMany(mappedBy: "category", targetEntity: CategoryDiscountEntity::class)]
    public Collection $discounts;
}
