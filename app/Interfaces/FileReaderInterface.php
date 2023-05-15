<?php

namespace App\Interfaces;

interface FileReaderInterface
{
    public function isFileReadable(): bool;

    public function isFileExist(): bool;

    public function read(): string;

    public function readLines(): iterable;
}