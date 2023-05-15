<?php

namespace App\Tests\Cache;

use App\Cache\RedisCache;
use App\Interfaces\CacheInterface;
use PHPUnit\Framework\TestCase;
use Redis;

class RedisCacheTest extends TestCase
{
    private Redis $redis;
    private CacheInterface $cache;

    protected function setUp(): void
    {
        parent::setUp();

        $this->redis = $this->getMockBuilder(Redis::class)
            ->disableOriginalConstructor()
            ->getMock();
        $this->cache = new RedisCache($this->redis);
    }

    public function testGet(): void
    {
        $key = 'test_key';
        $value = 'test_value';

        $this->redis->expects($this->once())
            ->method('get')
            ->with($key)
            ->willReturn($value);

        $this->assertSame($value, $this->cache->get($key));
    }

    public function testGetReturnsNull(): void
    {
        $key = 'test_key';

        $this->redis->expects($this->once())
            ->method('get')
            ->with($key)
            ->willReturn(null);

        $this->assertNull($this->cache->get($key));
    }

    public function testSet(): void
    {
        $key = 'test_key';
        $value = 'test_value';

        $this->redis->expects($this->once())
            ->method('set')
            ->with($key, $value);

        $this->cache->set($key, $value);
    }

    public function testDelete(): void
    {
        $key = 'test_key';

        $this->redis->expects($this->once())
            ->method('del')
            ->with($key);

        $this->cache->delete($key);
    }

    public function testClear(): void
    {
        $this->redis->expects($this->once())
            ->method('flushDB');

        $this->cache->clear();
    }

    public function testHas(): void
    {
        $key = 'test_key';

        $this->redis->expects($this->once())
            ->method('exists')
            ->with($key)
            ->willReturn(true);

        $this->assertTrue($this->cache->has($key));
    }

    public function testHasReturnsFalse(): void
    {
        $key = 'test_key';

        $this->redis->expects($this->once())
            ->method('exists')
            ->with($key)
            ->willReturn(false);

        $this->assertFalse($this->cache->has($key));
    }

    public function testMset(): void
    {
        $values = [
            'key1' => 'value1',
            'key2' => 'value2',
            'key3' => 'value3',
        ];

        $this->redis->expects($this->once())
            ->method('mset')
            ->with($values);

        $this->cache->mset($values);
    }

    public function testExpire(): void
    {
        $key = 'test_key';
        $seconds = 60;

        $this->redis->expects($this->once())
            ->method('expire')
            ->with($key, $seconds);

        $this->cache->expire($key, $seconds);
    }
}
