<?php

namespace App\Interfaces;

use App\Exceptions\HttpClientException;

interface HttpClientInterface
{
    /**
     * @throws HttpClientException
     */
    public function get(string $url, array $options): string;
}