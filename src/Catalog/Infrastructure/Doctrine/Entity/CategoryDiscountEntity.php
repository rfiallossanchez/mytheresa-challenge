<?php

declare(strict_types=1);

namespace Challenge\Catalog\Infrastructure\Doctrine\Entity;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\Table(name: "category_discount")]
class CategoryDiscountEntity
{
    #[ORM\Id]
    #[ORM\ManyToOne(targetEntity: CategoryEntity::class, inversedBy: "categoryDiscounts")]
    #[ORM\JoinColumn(name: "category_name", referencedColumnName: "name")]
    public CategoryEntity $category;

    #[ORM\Id]
    #[ORM\ManyToOne(targetEntity: DiscountEntity::class, inversedBy: "categoryDiscounts")]
    #[ORM\JoinColumn(name: "discount_id", referencedColumnName: "id")]
    public DiscountEntity $discount;
}