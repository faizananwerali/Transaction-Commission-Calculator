<?php

namespace App\Cache;

use App\Interfaces\RedisSingletonInterface;
use App\Services\Config;
use Redis;
use RedisException;

/**
 * The RedisSingleton class provides a singleton Redis instance for the application.
 */
class RedisSingleton implements RedisSingletonInterface
{
    /**
     * The singleton Redis instance.
     */
    private static ?Redis $instance = null;

    /**
     * Gets the singleton Redis instance.
     *
     * @throws RedisException if there is an error connecting to Redis.
     */
    public static function getInstance(): Redis
    {
        if (!self::$instance) {
            self::$instance = new Redis();
            self::$instance->connect(
                Config::get('REDIS_HOST', '127.0.0.1'),
                (int)Config::get('REDIS_PORT', '6379')
            );
        }

        return self::$instance;
    }
}
