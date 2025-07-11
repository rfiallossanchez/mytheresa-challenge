<?php

declare(strict_types=1);

namespace Challenge\Shared\Infrastructure\Cache;

use Challenge\Shared\Domain\Cache\CacheService;
use Psr\Cache\InvalidArgumentException;
use Redis;
use Symfony\Component\Cache\Adapter\RedisAdapter;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Contracts\Cache\CacheInterface;

class RedisCacheService implements CacheService
{
    private CacheInterface $cache;

    public function __construct(
        Redis $connection,
        ParameterBagInterface $config,
    )
    {
        $this->cache = new RedisAdapter(
            $connection,
            $config->get('redis.namespace'),
            $config->get('redis.ttl')
        );
    }

    /**
     * @throws InvalidArgumentException
     */
    public function find(string $key)
    {
        $item = $this->cache->getItem($key);

        return $item->isHit() ? $item->get() : null;
    }

    /**
     * @throws InvalidArgumentException
     */
    public function save(string $key, $value, int $ttl = 3600): void
    {
        $item = $this->cache->getItem($key);
        $item->set($value);
        $item->expiresAfter($ttl);

        $this->cache->save($item);
    }

    /**
     * @throws InvalidArgumentException
     */
    public function remove(string $key): void
    {
        $this->cache->deleteItem($key);
    }
}
