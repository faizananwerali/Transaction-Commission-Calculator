<?php

namespace App\Commands;

use App\Exceptions\FileNotFoundException;
use App\Exceptions\FileNotReadableException;
use App\Interfaces\CommandInterface;
use InvalidArgumentException;

/**
 * Abstract Command class that provides basic file validation and execution functionality.
 */
abstract class Command implements CommandInterface
{
    /**
     * The name of the file that this command will execute.
     *
     * @var string
     */
    public string $filename;

    /**
     * Constructs a new Command instance with the specified file name.
     *
     * @param string $filename The name of the file to execute.
     */
    public function __construct(string $filename)
    {
        $this->filename = $filename;
    }

    /**
     * Executes this command by first validating the file, and then calling the doExecute method.
     *
     * @throws FileNotFoundException If the file is not found
     * @throws FileNotReadableException If the file is not readable.
     */
    public function execute(): void
    {
        if (!file_exists($this->filename)) {
            throw new FileNotFoundException("File '{$this->filename}' not found.");
        }

        if (!is_readable($this->filename)) {
            throw new FileNotReadableException("File '{$this->filename}' is not readable.");
        }

        $this->doExecute();
    }

    /**
     * Executes the main functionality of this command.
     */
    abstract protected function doExecute(): void;
}
