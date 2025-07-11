<?php

declare(strict_types=1);

namespace Challenge\Catalog\Infrastructure\Doctrine\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\Table(name: "discount")]
class DiscountEntity
{
    #[ORM\Id]
    #[ORM\Column]
    public string $id;

    #[ORM\Column]
    public float $percentage;

    #[ORM\OneToMany(mappedBy: "discount", targetEntity: ProductDiscountEntity::class)]
    public Collection $productDiscounts;

    #[ORM\OneToMany(mappedBy: "discount", targetEntity: CategoryDiscountEntity::class)]
    public Collection $categoryDiscounts;

    public function __construct()
    {
        $this->productDiscounts = new ArrayCollection();
        $this->categoryDiscounts = new ArrayCollection();
    }
}
