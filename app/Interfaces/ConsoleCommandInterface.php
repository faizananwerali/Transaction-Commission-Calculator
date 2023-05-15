<?php

namespace App\Interfaces;

use App\Exceptions\CommissionCalculationException;
use App\Exceptions\CurrencyConversionException;

interface ConsoleCommandInterface extends CommandInterface
{
    /**
     * @throws CommissionCalculationException
     * @throws CurrencyConversionException
     */
    public function doExecute(): void;
}