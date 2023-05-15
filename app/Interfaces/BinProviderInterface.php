<?php

namespace App\Interfaces;

interface BinProviderInterface
{
    public function getCountry(string $bin): string;
}