<?php

namespace App\Interfaces;

interface ConfigInterface
{
    public static function load(string $path): void;

    public static function get(string $key, $default = null);
}