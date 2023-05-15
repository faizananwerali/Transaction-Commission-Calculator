<?php

namespace App\Interfaces;

interface CurrencyRateProviderInterface
{
    public function getRate(string $currency): float;
}