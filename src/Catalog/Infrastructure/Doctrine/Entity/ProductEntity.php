<?php

declare(strict_types=1);

namespace Challenge\Catalog\Infrastructure\Doctrine\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\Table(name: "product")]
class ProductEntity
{
    #[ORM\Id]
    #[ORM\Column]
    public string $sku;

    #[ORM\Column]
    public string $name;

    #[ORM\Column(name: 'price_amount')]
    public int $priceAmount;

    #[ORM\Column(name: 'price_currency')]
    public string $priceCurrency = 'EUR';

    #[ORM\ManyToOne(targetEntity: CategoryEntity::class)]
    #[ORM\JoinColumn(name: "category", referencedColumnName: "name")]
    public CategoryEntity $category;

    #[ORM\OneToMany(mappedBy: "product", targetEntity: ProductDiscountEntity::class)]
    public Collection $productDiscounts;

    public function __construct()
    {
        $this->productDiscounts = new ArrayCollection();
    }
}
