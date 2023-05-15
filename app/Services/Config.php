<?php

namespace App\Services;

use App\Interfaces\ConfigInterface;

/**
 * The Config class loads environment variables from a file and provides a method for retrieving those variables.
 */
class Config implements ConfigInterface
{
    /** @var array Stores the loaded environment variables. */
    private static array $data = [];

    /**
     * Loads environment variables from the specified file.
     *
     * @param string $path The path to the file containing the environment variables.
     * @return void
     */
    public static function load(string $path): void
    {
        EnvLoader::load($path);
        self::$data = $_ENV;
    }

    /**
     * Gets the value of the specified environment variable.
     *
     * @param string $key The name of the environment variable.
     * @param mixed $default The default value to return if the environment variable is not found.
     * @return mixed The value of the environment variable or the default value.
     */
    public static function get(string $key, $default = null)
    {
        return self::$data[$key] ?? $default;
    }
}
