<?php

declare(strict_types=1);

namespace Challenge\Shared\Domain\Cache;

interface CacheService
{
    public function find(string $key);

    public function save(string $key, $value, int $ttl = 3600): void;

    public function remove(string $key): void;
}
