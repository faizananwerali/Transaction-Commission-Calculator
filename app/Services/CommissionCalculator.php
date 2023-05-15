<?php

namespace App\Services;

use App\Exceptions\CommissionCalculationException;
use App\Exceptions\CurrencyConversionException;
use App\Interfaces\BinProviderInterface;
use App\Interfaces\CommissionCalculatorInterface;
use App\Interfaces\CurrencyRateProviderInterface;
use stdClass;

/**
 * Commission Calculator class to calculate commissions for given transactions.
 */
class CommissionCalculator implements CommissionCalculatorInterface
{
    private array $euCountries = [
        'AT',
        'BE',
        'BG',
        'CY',
        'CZ',
        'DE',
        'DK',
        'EE',
        'ES',
        'FI',
        'FR',
        'GR',
        'HR',
        'HU',
        'IE',
        'IT',
        'LT',
        'LU',
        'LV',
        'MT',
        'NL',
        'PO',
        'PT',
        'RO',
        'SE',
        'SI',
        'SK',
    ];
    private BinProviderInterface $binList;
    private CurrencyRateProviderInterface $exchangeRatesApi;

    /**
     * CommissionCalculator constructor.
     *
     * @param BinProviderInterface $binList The bin list API instance.
     * @param CurrencyRateProviderInterface $exchangeRatesApi The exchange rates API instance.
     */
    public function __construct(BinProviderInterface $binList, CurrencyRateProviderInterface $exchangeRatesApi)
    {
        $this->binList = $binList;
        $this->exchangeRatesApi = $exchangeRatesApi;
    }

    /**
     * Calculate commission for given transaction.
     *
     * @param stdClass $transaction The transaction data.
     * @return float The calculated commission.
     * @throws CommissionCalculationException If commission calculation fails.
     * @throws CurrencyConversionException If currency conversion fails.
     */
    public function calculateCommission(stdClass $transaction): float
    {
        $bin = $transaction->bin;
        $amount = (float)$transaction->amount;
        $currency = $transaction->currency;

        $country = $this->binList->getCountry($bin);
        $rate = $this->exchangeRatesApi->getRate($currency);

        $fixedAmount = $currency == 'EUR' || $rate == 0 ? $amount : $this->convertCurrency($amount, $rate);
        $commissionRate = $this->isEu($country) ? 0.01 : 0.02;
        return $this->roundUp($fixedAmount * $commissionRate); // commission
    }

    private function isEu($countryCode): bool
    {
        return in_array($countryCode, $this->euCountries);
    }

    /**
     * Convert given amount to euro using the given rate.
     *
     * @param float $amount The amount to convert.
     * @param float $rate The rate to use for conversion.
     * @return float The converted amount.
     * @throws CurrencyConversionException If currency conversion fails.
     */
    private function convertCurrency(float $amount, float $rate = 0): float
    {
        if ($rate === 0) {
            throw new CurrencyConversionException('Cannot divide by zero.');
        }
        return $amount / $rate;
    }

    /**
     * Round up given value to two decimal places.
     *
     * @param float $value The value to round up.
     * @return float The rounded up value.
     * @throws CommissionCalculationException If rounding fails.
     */
    private function roundUp(float $value): float
    {
        $rounded = ceil($value * 100) / 100;
        if ($rounded <= 0) {
            throw new CommissionCalculationException('Failed to round up value.');
        }
        return $rounded;
    }
}
