<?php

namespace App\Interfaces;

use App\Exceptions\CommissionCalculationException;
use App\Exceptions\CurrencyConversionException;

interface CommissionCalculatorInterface
{
    /**
     * Calculate commission for given transaction.
     *
     * @throws CommissionCalculationException If commission calculation fails.
     * @throws CurrencyConversionException If currency conversion fails.
     */
    public function calculateCommission(\stdClass $transaction): float;
}