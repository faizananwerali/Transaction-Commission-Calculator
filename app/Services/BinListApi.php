<?php

namespace App\Services;

use App\Interfaces\BinProviderInterface;
use App\Interfaces\HttpClientInterface;
use App\Exceptions;

/**
 * Class BinListApi
 *
 * This class is responsible for querying the BinList API to obtain information about a given BIN (Bank Identification Number).
 */
class BinListApi implements BinProviderInterface
{
    /**
     * @var HttpClientInterface An instance of the HTTP client used to make requests to the BinList API.
     */
    private HttpClientInterface $httpClient;

    /**
     * @var array An associative array used as a cache to store the country code for a given BIN.
     */
    private array $cache = [];

    /**
     * BinListApi constructor.
     *
     * @param HttpClientInterface $httpClient An instance of the HTTP client used to make requests to the BinList API.
     */
    public function __construct(HttpClientInterface $httpClient)
    {
        $this->httpClient = $httpClient;
    }

    /**
     * Get the country code for the given BIN number.
     *
     * @param string $bin The BIN number to look up.
     * @return string The two-letter country code for the BIN number.
     * @throws \App\Exceptions\HttpClientException If there is an error with the HTTP client.
     */
    public function getCountry(string $bin): string
    {
        // Check if the result is already in the cache
        if (isset($this->cache[$bin])) {
            // If so, return the cached result
            return $this->cache[$bin];
        }

        // If the result is not in the cache, make a request to the API
        $response = $this->httpClient->get("https://lookup.binlist.net/$bin");

        // Parse the JSON response
        $data = json_decode($response, true);

        // Extract the two-letter country code from the response
        $countryCode = $data['country']['alpha2'];

        // Store the result in the cache
        $this->cache[$bin] = $countryCode;

        // Return the two-letter country code
        return $countryCode;
    }
}
