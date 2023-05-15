<?php

namespace App\Services;

use App\Exceptions\FileNotFoundException;
use App\Exceptions\FileNotReadableException;
use App\Interfaces\FileReaderInterface;
use Generator;

/**
 * A class for reading files.
 */
class FileReader implements FileReaderInterface
{
    /**
     * The path to the file to be read.
     *
     * @var string
     */
    private string $filename;

    /**
     * Constructs a new FileReader instance.
     *
     * @param string $filename The path to the file to be read.
     */
    public function __construct(string $filename)
    {
        $this->filename = $filename;
    }

    /**
     * Checks if the file is readable.
     *
     * @return bool True if the file is readable, false otherwise.
     */
    public function isFileReadable(): bool
    {
        return is_readable($this->filename);
    }

    /**
     * Checks if the file exists.
     *
     * @return bool True if the file exists, false otherwise.
     */
    public function isFileExist(): bool
    {
        return file_exists($this->filename);
    }

    /**
     * Reads the entire contents of a file and returns it as a string.
     * Throws an exception if the file is not readable or does not exist.
     *
     * @return string The contents of the file as a string.
     * @throws FileNotReadableException|FileNotFoundException
     */
    public function read(): string
    {
        // Check if the file exists and is readable
        // If not, throw an exception
        if (!$this->isFileExist()) {
            throw new FileNotFoundException($this->filename);
        }
        if (!$this->isFileReadable()) {
            throw new FileNotReadableException("Could not read file: {$this->filename}");
        }

        // Read the file contents into a string
        // and return it
        return file_get_contents($this->filename);
    }

    /**
     * Reads the contents of a file line by line and returns an Generator of lines.
     * Uses a generator to avoid reading the entire file into memory.
     * Throws an exception if the file is not readable or does not exist.
     *
     * @return Generator Generator of file lines.
     * @throws FileNotReadableException|FileNotFoundException
     */
    public function readLines(): Generator
    {
        // Check if the file exists and is readable
        // If not, throw an exception
        if (!$this->isFileExist()) {
            throw new FileNotFoundException($this->filename);
        }
        if (!$this->isFileReadable()) {
            throw new FileNotReadableException("Could not read file: {$this->filename}");
        }

        // Open the file and read it line by line
        // using a generator to avoid reading the entire file into memory
        $handle = $this->getFileHandler();
        try {
            while (!feof($handle)) {
                $line = fgets($handle);
                if ($line !== false) {
                    yield $line;
                }
            }
        } finally {
            $this->closeFileHandler($handle);
        }
    }

    /**
     * Returns a file handler resource for reading the current file, or throws a FileNotReadableException if the file cannot be opened for reading.
     *
     * @return resource The file handler resource
     * @throws FileNotReadableException If the file could not be opened for reading.
     */
    private function getFileHandler()
    {
        $file = fopen($this->filename, 'r');
        if (!$file) {
            throw new FileNotReadableException("Could not open file: {$this->filename}");
        }

        return $file;
    }

    /**
     * Closes the given file handler resource, or throws a FileNotReadableException if the file could not be closed properly.
     *
     * @param resource $file The file handler resource to close.
     * @return void
     * @throws FileNotReadableException If the file could not be closed properly.
     */
    private function closeFileHandler($file): void
    {
        if (!fclose($file)) {
            throw new FileNotReadableException("Could not close file: {$this->filename}");
        }
    }
}
