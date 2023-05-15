<?php

use App\Cache\RedisSingleton;
use PHPUnit\Framework\TestCase;

class RedisSingletonTest extends TestCase
{
    public function testGetInstanceReturnsRedisInstance()
    {
        $redis = RedisSingleton::getInstance();

        $this->assertInstanceOf(Redis::class, $redis);
    }

    public function testGetInstanceReturnsSameRedisInstance()
    {
        $redis1 = RedisSingleton::getInstance();
        $redis2 = RedisSingleton::getInstance();

        $this->assertSame($redis1, $redis2);
    }

//    public function testGetInstanceThrowsExceptionIfRedisNotRunning()
//    {
//        $this->expectException(RedisException::class);
//
//        putenv("REDIS_HOST=127.0.0.2");
//
//        RedisSingleton::getInstance();
//    }
}
