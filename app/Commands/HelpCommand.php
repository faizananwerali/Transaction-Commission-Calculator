<?php

namespace App\Commands;

use App\Interfaces\CommandInterface;
use InvalidArgumentException;

/**
 * A console command that displays help information for how to use the application.
 */
class HelpCommand implements CommandInterface
{
    private bool $throwException = false;

    /**
     * Executes the command, displaying usage instructions for the application.
     *
     * @throws InvalidArgumentException
     */
    public function execute(): void
    {
        if ($this->throwException) {
            throw new InvalidArgumentException("Invalid arguments provided." . PHP_EOL . $this->getMessage());
        } else {
            echo $this->getMessage();
            //exit();
        }
    }

    public function setShouldThrowException(bool $throwException): void
    {
        $this->throwException = $throwException;
    }

    private function getMessage(): string
    {
        return "Usage: php index.php <filename>" . PHP_EOL . "  <filename> : Path to a valid readable file." . PHP_EOL;
    }
}
