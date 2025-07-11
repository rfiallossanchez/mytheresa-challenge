<?php

declare(strict_types=1);

namespace Challenge\Tests\Catalog\Application\Search;

use Challenge\Catalog\Application\Search\Resource\PriceResource;
use Challenge\Catalog\Application\Search\Resource\ProductResource;
use Challenge\Catalog\Application\Search\SearchProductQuery;
use Challenge\Catalog\Application\Search\SearchProductUseCase;
use Challenge\Catalog\Domain\Repository\ProductCriteria;
use Challenge\Catalog\Domain\Repository\ProductRepository;
use Challenge\Shared\Domain\Cache\CacheService;
use Challenge\Tests\Catalog\MotherObject\ProductMother;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

final class SearchProductUseCaseTest extends TestCase
{
    private SearchProductUseCase $sut;
    private MockObject|CacheService $cacheService;
    private MockObject|ProductRepository $productRepository;

    public function setUp(): void
    {
        $this->cacheService = $this->createMock(CacheService::class);
        $this->productRepository = $this->createMock(ProductRepository::class);

        $this->sut = new SearchProductUseCase($this->cacheService, $this->productRepository);
    }

    public function testItFetchesProductsFromRepositoryIfCacheMiss(): void
    {
        $this->cacheService->expects($this->once())
            ->method('find')
            ->with('products_all_all')
            ->willReturn(null);

        $products = ProductMother::createMultiple();
        $this->productRepository->expects($this->once())
            ->method('searchByCriteria')
            ->with(ProductCriteria::create())
            ->willReturn($products);

        $expected = $this->expectedProductResource();
        $this->cacheService->expects($this->once())
            ->method('save')
            ->with('products_all_all', $expected);

        $result = ($this->sut)(new SearchProductQuery());

        foreach ($expected as $i => $expectedProduct) {
            $this->assertProductResourceEquals($expectedProduct, $result[$i]);
        }
    }

    public function testItReturnsProductsFromCacheIfAvailable(): void
    {
        $expected = $this->expectedProductResource();

        $this->cacheService->expects($this->once())
            ->method('find')
            ->with('products_all_all')
            ->willReturn($expected);

        $this->productRepository->expects($this->never())
            ->method('searchByCriteria');

        $this->cacheService->expects($this->never())
            ->method('save');

        $result = ($this->sut)(new SearchProductQuery());

        foreach ($expected as $i => $expectedProduct) {
            $this->assertProductResourceEquals($expectedProduct, $result[$i]);
        }
    }

    private function assertProductResourceEquals(ProductResource $expected, ProductResource $actual): void
    {
        $this->assertSame($expected->sku, $actual->sku);
        $this->assertSame($expected->name, $actual->name);
        $this->assertSame($expected->category, $actual->category);
        $this->assertSame($expected->price->original, $actual->price->original);
        $this->assertSame($expected->price->final, $actual->price->final);
        $this->assertSame($expected->price->discount_percentage, $actual->price->discount_percentage);
        $this->assertSame($expected->price->currency, $actual->price->currency);
    }

    private function expectedProductResource(): array
    {
        return [
            new ProductResource(
                '000001',
                'BVLean leather ankle boots',
                'boots',
                new PriceResource(
                    original: 89000,
                    final: 66750,
                    discount_percentage: '25%',
                    currency: 'EUR'
                )
            ),
            new ProductResource(
                '000002',
                'Nathane leather sneakers',
                'sneakers',
                new PriceResource(
                    original: 89000,
                    final: 89000,
                    discount_percentage: null,
                    currency: 'EUR'
                )
            ),
            new ProductResource(
                '000003',
                'Naima embellished suede sandals',
                'sandals',
                new PriceResource(
                    original: 89000,
                    final: 66750,
                    discount_percentage: '25%',
                    currency: 'EUR'
                )
            ),
        ];
    }
}
