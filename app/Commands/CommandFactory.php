<?php

namespace App\Commands;

use App\Interfaces\CommandFactoryInterface;
use App\Interfaces\CommandInterface;
use App\Services\FileReader;
use InvalidArgumentException;

class CommandFactory implements CommandFactoryInterface
{
    /**
     * Creates a command object based on the given arguments
     *
     * @param array $arguments The arguments to create the command object
     *
     * @return ?CommandInterface A command object
     */
    public function createCommand(array $arguments): ?CommandInterface
    {
        // Check if the correct number of arguments were provided and if not, show help and exit
        if (count($arguments) !== 2) {
            $this->showHelpAndExit(true);
        }
        if ($arguments[1] === '-h' || $arguments[1] === '--help') {
            $this->showHelpAndExit();
            return null;
        }

        $filename = $arguments[1];

        // Create and return a CommissionCommand object with a FileReader and the given filename
        return new CommissionCommand(new FileReader($filename), $filename);

        //Otherwise there are many way to handle multiple commands
        /*switch ($arguments[1]) {
            case 'commission':
                return new CommissionCommand($this->fileReader, $this->filename);
            default:
                throw new InvalidArgumentException("Invalid command '{$arguments[0]}'.");
        }*/
    }

    /**
     * Shows the help message and exits the application
     *
     * @return void
     */
    private function showHelpAndExit(bool $throwException = false): void
    {
        // Create a HelpCommand object and execute it
        $command = new HelpCommand();
        $command->setShouldThrowException($throwException);
        $command->execute();
    }
}
