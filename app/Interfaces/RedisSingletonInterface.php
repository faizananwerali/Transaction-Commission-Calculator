<?php

namespace App\Interfaces;

use Redis;
use RedisException;

interface RedisSingletonInterface
{
    /**
     * @throws RedisException
     */
    public static function getInstance(): Redis;
}