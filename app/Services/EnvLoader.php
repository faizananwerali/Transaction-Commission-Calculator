<?php

namespace App\Services;

use App\Interfaces\EnvLoaderInterface;
use Dotenv\Dotenv;

/**
 * Class EnvLoader
 * A class for loading environment variables from a .env file.
 *
 * @package App
 */
class EnvLoader implements EnvLoaderInterface
{
    /**
     * Loads environment variables from a .env file.
     *
     * @param string $path The path to the directory containing the .env file.
     *
     * @return void
     */
    public static function load(string $path): void
    {
        $dotenv = Dotenv::createImmutable($path);
        $dotenv->load();
    }
}
