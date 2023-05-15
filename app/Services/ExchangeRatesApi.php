<?php

namespace App\Services;

use App\Cache\Cache;
use App\Interfaces\CurrencyRateProviderInterface;
use App\Interfaces\HttpClientInterface;
use App\Exceptions;

/**
 * ExchangeRatesApi class provides functionality to retrieve exchange rate data for given currency from API and cache it.
 */
class ExchangeRatesApi implements CurrencyRateProviderInterface
{
    private HttpClientInterface $httpClient;

    private ?Cache $cache;

    /**
     * Create a new instance of ExchangeRatesApi.
     *
     * @param HttpClientInterface $httpClient An implementation of the HttpClientInterface to send HTTP requests.
     * @param Cache|null $cache An instance of Cache or null if caching is not needed.
     */
    public function __construct(HttpClientInterface $httpClient, ?Cache $cache)
    {
        $this->httpClient = $httpClient;
        $this->cache = $cache;
    }

    /**
     * Get the exchange rate for the given currency.
     *
     * @param string $currency The currency code (e.g. "USD")
     * @return float The exchange rate
     * @throws \App\Exceptions\HttpClientException if an error occurs while sending HTTP request or processing response.
     */
    public function getRate(string $currency): float
    {
        // Check if the result is already in the cache
        if ($this->cache && $this->cache->has($currency)) {
            return (float)$this->cache->get($currency);
        }

        // If not in cache, fetch from the API
        $headers = [
            'apikey' => Config::get('EXCHANGE_RATE_API_KEY', ''), // retrieve API key from configuration
        ];

        $options = [
            'headers' => $headers,
        ];

        $response = $this->httpClient->get("https://api.apilayer.com/exchangerates_data/latest", $options); // send GET request to retrieve exchange rate data
        $data = json_decode($response, true); // parse response data as an associative array
        if (!$data['success']) { // check if the request was successful
            throw new \App\Exceptions\HttpClientException('Failed to fetch exchange rates. Service responded with: ' . $data['error']['info'] ?? 'Unknown error'); // throw exception if request failed
        }

        if ($this->cache) {
            // Create an array to hold all the key-value pairs to store
            $kvPairs = [];

            foreach ($data['rates'] as $curr => $rate) {
                // Add each key-value pair to the array
                $kvPairs[$curr] = (string)$rate;
            }

            // Store all the key-value pairs in one command using MSET
            $this->cache->mset($kvPairs); // set exchange rate data in cache

            // Set expiration time for all keys to 24 hours
            $expirationTime = 24 * 60 * 60; // 24 hours in seconds
            foreach ($kvPairs as $curr => $rate) {
                $this->cache->expire($curr, $expirationTime); // set expiration time for each currency key
            }
        }

        return (float)($data['rates'][$currency] ?? 0); // return exchange rate for the given currency
    }
}
