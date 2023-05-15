<?php

namespace App\Interfaces;

interface EnvLoaderInterface
{
    public static function load(string $path): void;
}