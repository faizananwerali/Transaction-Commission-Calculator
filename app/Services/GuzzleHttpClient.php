<?php

namespace App\Services;

use App\Exceptions\HttpClientException;
use App\Interfaces\HttpClientInterface;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;

/**
 * GuzzleHttpClient is a class that implements the HttpClientInterface using GuzzleHttp\Client to send HTTP requests.
 */
class GuzzleHttpClient implements HttpClientInterface
{
    /**
     * @var Client The instance of GuzzleHttp\Client used to send HTTP requests.
     */
    private Client $client;

    /**
     * Constructor that initializes the instance of GuzzleHttp\Client.
     */
    public function __construct()
    {
        $this->client = new Client();
    }

    /**
     * Sends a GET request to the specified URL and returns the response body as a string.
     *
     * @param string $url The URL to send the request to.
     * @param array $options An optional array of request options to send with the request.
     * @return string The response body as a string.
     * @throws HttpClientException If an error occurs while sending the request.
     */
    public function get(string $url, array $options = []): string
    {
        try {
            // Send a GET request using GuzzleHttp\Client and get the response
            $response = $this->client->get($url, $options);

            // Get the contents of the response body and return it as a string
            return $response->getBody()->getContents();
        } catch (GuzzleException $e) {
            // Catch any errors that occur while sending the request and throw a HttpClientException
            throw new HttpClientException($e->getMessage());
        }
    }
}
