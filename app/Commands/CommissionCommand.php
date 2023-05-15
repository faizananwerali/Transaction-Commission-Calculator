<?php

namespace App\Commands;

use App\Cache\Cache;
use App\Cache\RedisCache;
use App\Cache\RedisSingleton;
use App\Exceptions\CommissionCalculationException;
use App\Exceptions\CurrencyConversionException;
use App\Interfaces\ConsoleCommandInterface;
use App\Services\BinListApi;
use App\Services\CommissionCalculator;
use App\Services\ExchangeRatesApi;
use App\Services\FileReader;
use App\Services\GuzzleHttpClient;
use App\Services\JsonLineByLineParser;
use Exception;
use InvalidArgumentException;

/**
 * CommissionCommand class is a concrete implementation of the abstract Command class.
 * It implements the ConsoleCommandInterface to provide a command-line interface to calculate commissions.
 */
class CommissionCommand extends Command implements ConsoleCommandInterface
{
    private FileReader $fileReader;
    private ?Cache $cache;

    /**
     * CommissionCommand constructor initializes FileReader and Cache.
     * It calls the parent constructor to set the filename.
     *
     * @param FileReader $fileReader - A FileReader object to read the input file.
     * @param string $filename - The filename of the input file.
     */
    public function __construct(FileReader $fileReader, string $filename)
    {
        parent::__construct($filename);
        $this->fileReader = $fileReader;
        try {
            $this->cache = new Cache(new RedisCache(RedisSingleton::getInstance()));
        } catch (Exception $e) {
            $this->cache = null;
        }
    }

    /**
     * This method is called when the commission command is executed.
     * It reads the input file line by line as JSON and calculates the commission for each transaction.
     *
     * @throws CommissionCalculationException - if commission calculation fails.
     * @throws CurrencyConversionException - if currency conversion fails.
     */
    public function doExecute(): void
    {
        $jsonParser = new JsonLineByLineParser($this->fileReader);
        foreach ($jsonParser->parseJson() as $transaction) {
            $this->checkTransactionObject($transaction);
            $client = new GuzzleHttpClient();
            $binList = new BinListApi($client);
            $exchangeRate = new ExchangeRatesApi($client, $this->cache);
            $commissionCalculator = new CommissionCalculator($binList, $exchangeRate);
            $commission = $commissionCalculator->calculateCommission($transaction);
            echo $commission . PHP_EOL;
        }
    }

    /**
     * This method checks if the transaction object has the necessary properties.
     *
     * @param object $transaction - A transaction object.
     *
     * @throws InvalidArgumentException - if transaction object is invalid.
     */
    private function checkTransactionObject(object $transaction): void
    {
        if (!isset($transaction->bin)) {
            throw new InvalidArgumentException('Transaction object must have a bin property.');
        }
        if (!isset($transaction->amount)) {
            throw new InvalidArgumentException('Transaction object must have an amount property.');
        }
        if (!isset($transaction->currency)) {
            throw new InvalidArgumentException('Transaction object must have a currency property.');
        }
    }
}
