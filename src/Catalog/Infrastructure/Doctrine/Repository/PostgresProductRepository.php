<?php

declare(strict_types=1);

namespace Challenge\Catalog\Infrastructure\Doctrine\Repository;

use Challenge\Catalog\Domain\Model\Product;
use Challenge\Catalog\Domain\Repository\ProductCriteria;
use Challenge\Catalog\Domain\Repository\ProductRepository;
use Challenge\Catalog\Infrastructure\Doctrine\Entity\ProductEntity;
use Challenge\Catalog\Infrastructure\Doctrine\Mapper\ProductMapper;
use Doctrine\ORM\EntityManagerInterface;

readonly class PostgresProductRepository implements ProductRepository
{
    public function __construct(private EntityManagerInterface $em)
    {
    }

    /**
     * @return Product[]
     */
    public function searchByCriteria(ProductCriteria $criteria): array
    {
        $qb = $this->em->createQueryBuilder()
            ->select('p')
            ->from(ProductEntity::class, 'p')
            ->setMaxResults($criteria->maxResults);

        if ($criteria->category) {
            $qb->andWhere('p.category = :category')
                ->setParameter('category', $criteria->category);
        }

        if ($criteria->priceLessThan) {
            $qb->andWhere('p.priceAmount <= :price')
                ->setParameter('price', $criteria->priceLessThan);
        }

        $entities = $qb->getQuery()->getResult();

        return array_map(
            fn(ProductEntity $e) => ProductMapper::toDomain($e),
            $entities
        );
    }
}
