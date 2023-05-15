<?php

namespace App\Cache;

use App\Interfaces\CacheInterface;
use Redis;
use RedisException;

/**
 * Class RedisCache
 * An implementation of CacheInterface using Redis for caching
 */
class RedisCache implements CacheInterface
{
    /**
     * The Redis instance used for caching
     * @var Redis
     */
    private Redis $redis;

    /**
     * RedisCache constructor.
     * @param Redis $redis The Redis instance to use for caching
     */
    public function __construct(Redis $redis)
    {
        $this->redis = $redis;
    }

    /**
     * Retrieve the value for the given key
     * @param string $key The key to retrieve the value for
     * @return string|null The value for the given key, or null if the key does not exist
     * @throws RedisException If there is an issue retrieving the value from Redis
     */
    public function get(string $key): ?string
    {
        return $this->redis->get($key);
    }

    /**
     * Set the value for the given key
     * @param string $key The key to set the value for
     * @param string $value The value to set
     * @throws RedisException If there is an issue setting the value in Redis
     */
    public function set(string $key, string $value): void
    {
        $this->redis->set($key, $value);
    }

    /**
     * Delete the value for the given key
     * @param string $key The key to delete the value for
     * @throws RedisException If there is an issue deleting the value from Redis
     */
    public function delete(string $key): void
    {
        $this->redis->del($key);
    }

    /**
     * Delete all values from the cache
     * @throws RedisException If there is an issue deleting all values from Redis
     */
    public function clear(): void
    {
        $this->redis->flushDB();
    }

    /**
     * Check if a value exists for the given key
     * @param string $key The key to check for existence
     * @return bool True if a value exists for the given key, false otherwise
     * @throws RedisException If there is an issue checking for existence in Redis
     */
    public function has(string $key): bool
    {
        return (bool) $this->redis->exists($key);
    }

    /**
     * Set multiple key-value pairs at once
     * @param array $values An array of key-value pairs to set
     * @throws RedisException If there is an issue setting multiple key-value pairs in Redis
     */
    public function mset(array $values): void
    {
        $this->redis->mset($values);
    }

    /**
     * Set a timeout for the given key
     * @param string $key The key to set the timeout for
     * @param int $seconds The number of seconds to set the timeout for
     * @throws RedisException If there is an issue setting the timeout in Redis
     */
    public function expire(string $key, int $seconds): void
    {
        $this->redis->expire($key, $seconds);
    }
}
