<?php

use App\Cache\Cache;
use App\Cache\RedisCache;
use PHPUnit\Framework\TestCase;

class CacheTest extends TestCase
{
    public function testGet()
    {
        $mockCache = $this->createMock(RedisCache::class);
        $mockCache->expects($this->once())
            ->method('get')
            ->with($this->equalTo('test_key'))
            ->willReturn('test_value');

        $cache = new Cache($mockCache);

        $this->assertEquals('test_value', $cache->get('test_key'));
    }

    public function testSet()
    {
        $mockCache = $this->createMock(RedisCache::class);
        $mockCache->expects($this->once())
            ->method('set')
            ->with($this->equalTo('test_key'), $this->equalTo('test_value'));

        $cache = new Cache($mockCache);

        $cache->set('test_key', 'test_value');
    }

    public function testDelete()
    {
        $mockCache = $this->createMock(RedisCache::class);
        $mockCache->expects($this->once())
            ->method('delete')
            ->with($this->equalTo('test_key'));

        $cache = new Cache($mockCache);

        $cache->delete('test_key');
    }

    public function testClear()
    {
        $mockCache = $this->createMock(RedisCache::class);
        $mockCache->expects($this->once())
            ->method('clear');

        $cache = new Cache($mockCache);

        $cache->clear();
    }

    public function testHas()
    {
        $mockCache = $this->createMock(RedisCache::class);
        $mockCache->expects($this->once())
            ->method('has')
            ->with($this->equalTo('test_key'))
            ->willReturn(true);

        $cache = new Cache($mockCache);

        $this->assertTrue($cache->has('test_key'));
    }

    public function testMset()
    {
        $mockCache = $this->createMock(RedisCache::class);
        $mockCache->expects($this->once())
            ->method('mset')
            ->with($this->equalTo(['test_key_1' => 'test_value_1', 'test_key_2' => 'test_value_2']));

        $cache = new Cache($mockCache);

        $cache->mset(['test_key_1' => 'test_value_1', 'test_key_2' => 'test_value_2']);
    }

    public function testExpire()
    {
        $mockCache = $this->createMock(RedisCache::class);
        $mockCache->expects($this->once())
            ->method('expire')
            ->with($this->equalTo('test_key'), $this->equalTo(60));

        $cache = new Cache($mockCache);

        $cache->expire('test_key', 60);
    }
}
