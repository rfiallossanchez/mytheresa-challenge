<?php

declare(strict_types=1);

namespace Challenge\Catalog\Infrastructure\Doctrine\Entity;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\Table(name: "product_discount")]
class ProductDiscountEntity
{
    #[ORM\Id]
    #[ORM\ManyToOne(targetEntity: ProductEntity::class, inversedBy: "productDiscounts")]
    #[ORM\JoinColumn(name: "product_sku", referencedColumnName: "sku")]
    public ProductEntity $product;

    #[ORM\Id]
    #[ORM\ManyToOne(targetEntity: DiscountEntity::class, inversedBy: "productDiscounts")]
    #[ORM\JoinColumn(name: "discount_id", referencedColumnName: "id")]
    public DiscountEntity $discount;
}
