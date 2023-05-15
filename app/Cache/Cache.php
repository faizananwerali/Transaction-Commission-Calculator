<?php

namespace App\Cache;

use App\Interfaces\CacheInterface;

/**
 * Class Cache
 *
 * This class implements the CacheInterface and serves as a wrapper around any class that also implements
 * the CacheInterface. It allows for easier swapping of underlying caching implementations.
 *
 * @package App\Cache
 */
class Cache implements CacheInterface
{
    /**
     * @var CacheInterface The underlying cache implementation to use
     */
    private CacheInterface $cache;

    /**
     * Cache constructor.
     *
     * @param CacheInterface $cache The underlying cache implementation to use
     */
    public function __construct(CacheInterface $cache)
    {
        $this->cache = $cache;
    }

    /**
     * {@inheritDoc}
     */
    public function get(string $key): ?string
    {
        return $this->cache->get($key);
    }

    /**
     * {@inheritDoc}
     */
    public function set(string $key, string $value): void
    {
        $this->cache->set($key, $value);
    }

    /**
     * {@inheritDoc}
     */
    public function delete(string $key): void
    {
        $this->cache->delete($key);
    }

    /**
     * {@inheritDoc}
     */
    public function clear(): void
    {
        $this->cache->clear();
    }

    /**
     * {@inheritDoc}
     */
    public function has(string $key): bool
    {
        return $this->cache->has($key);
    }

    /**
     * {@inheritDoc}
     */
    public function mset(array $values): void
    {
        $this->cache->mset($values);
    }

    /**
     * {@inheritDoc}
     */
    public function expire(string $key, int $seconds): void
    {
        $this->cache->expire($key, $seconds);
    }
}
