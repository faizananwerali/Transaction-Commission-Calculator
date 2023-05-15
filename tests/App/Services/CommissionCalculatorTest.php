<?php

namespace App\Tests;

use App\Exceptions\CommissionCalculationException;
use App\Exceptions\CurrencyConversionException;
use App\Interfaces\BinProviderInterface;
use App\Interfaces\CurrencyRateProviderInterface;
use App\Services\CommissionCalculator;
use Mockery;
use PHPUnit\Framework\TestCase;
use stdClass;

class CommissionCalculatorTest extends TestCase
{
    /**
     * @throws CurrencyConversionException
     * @throws CommissionCalculationException
     */
    public function testCalculateCommission(): void
    {
        $row = new stdClass();
        $row->bin = '123456';
        $row->amount = 100.00;
        $row->currency = 'USD';

        $binlist = Mockery::mock(BinProviderInterface::class);
        $binlist->shouldReceive('getCountry')->andReturn('SK');

        $exchangeRatesApi = Mockery::mock(CurrencyRateProviderInterface::class);
        $exchangeRatesApi->shouldReceive('getRate')->andReturn(1.20);

        $calculator = new CommissionCalculator($binlist, $exchangeRatesApi);
        $result = $calculator->calculateCommission($row);

        $this->assertEquals(1.00, $result);
    }
}