<?php

namespace App\Services;

use App\Interfaces\JsonLineByLineParserInterface;
use Generator;
use PHPUnit\Util\InvalidJsonException;

/**
 * JsonLineByLineParser is a class that implements the JsonLineByLineParserInterface
 * and parses a file containing JSON objects line by line.
 */
class JsonLineByLineParser implements JsonLineByLineParserInterface
{
    /**
     * @var FileReader The FileReader instance used to read lines from the file.
     */
    private FileReader $fileReader;

    /**
     * Constructor that initializes the FileReader instance used to read lines from the file.
     *
     * @param FileReader $fileReader The FileReader instance to use for reading lines from the file.
     */
    public function __construct(FileReader $fileReader)
    {
        $this->fileReader = $fileReader;
    }

    /**
     * Parses a file containing JSON objects line by line and yields each parsed object.
     *
     * @return Generator The generator that yields each parsed JSON object.
     * @throws InvalidJsonException If invalid JSON is found in the file.
     */
    public function parseJson(): Generator
    {
        // Iterate over the lines in the file
        foreach ($this->fileReader->readLines() as $line) {
            // Parse the JSON object in the line
            $parsedObject = json_decode($line);

            // Throw an exception if the JSON object is invalid
            if ($parsedObject === null && json_last_error() !== JSON_ERROR_NONE) {
                throw new InvalidJsonException('Invalid JSON found in file');
            }

            // Yield the parsed JSON object
            yield $parsedObject;
        }
    }
}
