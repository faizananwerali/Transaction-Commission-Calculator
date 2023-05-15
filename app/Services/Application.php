<?php

namespace App\Services;

use App\Commands\CommandFactory;
use App\Interfaces\ApplicationInterface;
use Exception;

/**
 * Application class responsible for running the command line application.
 */
class Application implements ApplicationInterface
{
    /**
     * Runs the command line application by creating a command object and executing it.
     *
     * @param array $argv The command line arguments passed to the application.
     *
     * @return void
     */
    public function run(array $argv): void
    {
        try {
            // Create a command object based on the command line arguments.
            $factory = new CommandFactory();
            $command = $factory->createCommand($argv);
            if (!is_null($command)) {
                // Execute the command.
                $command->execute();
            }
        } catch (Exception $e) {
            // Display error message and exit with status code 1 on error.
            echo "Error: " . $e->getMessage() . "\n";
            //exit(1);
        }
    }
}
