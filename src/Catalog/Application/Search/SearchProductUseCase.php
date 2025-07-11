<?php

declare(strict_types=1);

namespace Challenge\Catalog\Application\Search;

use Challenge\Catalog\Application\Search\Resource\PriceResource;
use Challenge\Catalog\Application\Search\Resource\ProductResource;
use Challenge\Catalog\Domain\Repository\ProductCriteria;
use Challenge\Catalog\Domain\Repository\ProductRepository;
use Challenge\Shared\Domain\Cache\CacheService;

readonly class SearchProductUseCase
{
    private const int CACHE_ONE_DAY_TTL = 86400;

    public function __construct(
        private CacheService $cacheService,
        private ProductRepository $productRepository
    )
    {
    }

    /**
     * @return ProductResource[]
     */
    public function __invoke(SearchProductQuery $query): array
    {
        $productCacheKey = $this->buildCacheKey($query->category, $query->priceLessThan);
        $productsResource = $this->cacheService->find($productCacheKey);
        if ($productsResource) {
            return $productsResource;
        }

        $products = $this->productRepository->searchByCriteria(
            ProductCriteria::create($query->category, $query->priceLessThan),
        );

        $productsResource = [];
        foreach ($products as $product) {
            $priceResource = new PriceResource(
                $product->originalPrice()->amount,
                $product->calculateFinalPrice()->amount,
                $product->discountedPercentage(),
                $product->originalPrice()->currency
            );
            $productsResource[] = new ProductResource(
                $product->sku(),
                $product->name(),
                $product->category(),
                $priceResource
            );
        }

        $this->cacheService->save($productCacheKey, $productsResource, self::CACHE_ONE_DAY_TTL);

        return $productsResource;
    }

    private function buildCacheKey(?string $category, ?int $priceLessThan): string
    {
        return 'products_' . ($category ?: 'all') . '_' . ($priceLessThan ?: 'all');
    }
}
