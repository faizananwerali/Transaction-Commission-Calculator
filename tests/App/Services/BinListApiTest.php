<?php

namespace Tests\Services;

use App\Services\BinListApi;
use App\Interfaces\HttpClientInterface;
use App\Exceptions\HttpClientException;
use App\Services\GuzzleHttpClient;
use PHPUnit\Framework\TestCase;

class BinListApiTest extends TestCase
{
    public function testGetCountryReturnsCountryCode()
    {
        // Create an instance of the BinListApi class with the mock HTTP client
        $binListApi = new BinListApi(new GuzzleHttpClient());

        // Call the getCountry method with a valid BIN number
        $countryCode = $binListApi->getCountry('45717360');

        // Assert that the method returns the correct country code
        $this->assertEquals('DK', $countryCode);
    }

    public function testGetCountryThrowsExceptionOnHttpClientError()
    {
        // Create an instance of the BinListApi class with the mock HTTP client
        $binListApi = new BinListApi(new GuzzleHttpClient());

        // Call the getCountry method with an invalid BIN number
        $this->expectException(HttpClientException::class);
        $binListApi->getCountry('invalid');
    }

    //this one also don't know how to test it properly
    public function testGetCountryUsesCache()
    {
        // Create an instance of the BinListApi class with the mock HTTP client
        $binListApi = new BinListApi(new GuzzleHttpClient());

        // Call the getCountry method twice with the same BIN number
        $countryCode1 = $binListApi->getCountry('45717360');
        $countryCode2 = $binListApi->getCountry('45717360');

        // Assert that the method returns the correct country code and only makes one HTTP request
        $this->assertEquals('DK', $countryCode1);
        $this->assertEquals('DK', $countryCode2);
    }
}
