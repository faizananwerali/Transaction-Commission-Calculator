<?php

use App\Exceptions\CommissionCalculationException;
use App\Exceptions\CurrencyConversionException;
use App\Exceptions\FileNotFoundException;
use PHPUnit\Framework\TestCase;
use App\Commands\CommissionCommand;
use App\Services\FileReader;
use App\Services\JsonLineByLineParser;
use App\Services\CommissionCalculator;
use App\Cache\Cache;
use App\Cache\RedisCache;
use App\Cache\RedisSingleton;
use App\Services\BinListApi;
use App\Services\ExchangeRatesApi;
use App\Services\GuzzleHttpClient;

class CommissionCommandTest extends TestCase
{
    /**
     * Test case for valid input file and output.
     */
//    public function testValidInputFile()
//    {
//        // Create CommissionCommand object with mocked FileReader
//        $commissionCommand = new CommissionCommand(new FileReader('../test_files/input.txt'), '../test_files/input.txt');
//
//        // Call execute() method and check the output
//        $this->expectOutputString("0.30" . PHP_EOL);
//        $commissionCommand->execute();
//    }

    /**
     * Test case for invalid input file.
     */
    public function testInvalidInputFile()
    {
        // Create CommissionCommand object with mocked FileReader object
        $commissionCommand = new CommissionCommand(new FileReader('input.txt'), 'input.txt');

        // Call execute() method and check if the exception is thrown
        $this->expectException(FileNotFoundException::class);
        $this->expectExceptionMessage("File 'input.txt' not found.");
        $commissionCommand->execute();
    }

//    /**
//     * Test case for CurrencyConversionException while calculating commission.
//     */
//    public function testCurrencyConversionException()
//    {
//        $filename = 'input.txt';
//        $this->expectException(CurrencyConversionException::class);
//        $this->expectExceptionMessage('Cannot divide by zero.');
//        $commissionCommandMock = $this->getMockBuilder(CommissionCommand::class)
//            ->setConstructorArgs([new FileReader($filename), $filename])
//            ->getMock();;
//        $commissionCommandMock->method('doExecute')->willThrowException(throw new CurrencyConversionException('Cannot divide by zero.'));
//    }
//
//    /**
//     * Test case for CommissionCalculationException while calculating commission.
//     */
//    public function testCommissionCalculationException()
//    {
//        $filename = 'input.txt';
//        $this->expectException(CommissionCalculationException::class);
//        $this->expectExceptionMessage('Failed to round up value.');
//        $commissionCommandMock = $this->getMockBuilder(CommissionCommand::class)
//            ->setConstructorArgs([new FileReader($filename), $filename])
//            ->getMock();;
//        $commissionCommandMock->method('doExecute')->willThrowException(throw new CommissionCalculationException('Failed to round up value.'));
//    }
}
