<?php

namespace App\Interfaces;

interface CacheInterface
{
    /**
     * Get the value associated with the given key.
     *
     * @param string $key The cache key
     * @return string|null The cached value or null if it doesn't exist
     */
    public function get(string $key): ?string;

    /**
     * Set the value associated with the given key.
     *
     * @param string $key The cache key
     * @param string $value The value to cache
     * @return void
     */
    public function set(string $key, string $value): void;

    public function delete(string $key): void;

    public function clear(): void;

    public function has(string $key): bool;

    public function mset(array $values): void;

    public function expire(string $key, int $seconds): void;
}
