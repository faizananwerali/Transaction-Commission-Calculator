<?php

namespace App\Interfaces;

use Generator;
use PHPUnit\Util\InvalidJsonException;

interface JsonLineByLineParserInterface
{
    /**
     * Parses a file containing JSON objects line by line and yields each parsed object.
     *
     * @return Generator
     * @throws InvalidJsonException if invalid JSON is found in the file
     */
    public function parseJson(): Generator;
}