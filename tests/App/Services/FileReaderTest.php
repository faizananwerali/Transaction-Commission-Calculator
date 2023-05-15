<?php

namespace App\Tests;

use App\Exceptions\FileNotFoundException;
use App\Exceptions\FileNotReadableException;
use App\Services\FileReader;
use PHPUnit\Framework\TestCase;

class FileReaderTest extends TestCase
{
    public function testRead()
    {
        $fileReader = new FileReader(dirname(__DIR__, 1) . '/test_files/test.json');
        $data = $fileReader->read();
        $expected = "{\n  \"name\": \"John Doe\",\n  \"age\": 30,\n  \"email\": \"john@example.com\"\n}";
        $this->assertEquals($expected, $data);
    }

    public function testReadLines()
    {
        $fileReader = new FileReader(dirname(__DIR__, 1) . '/test_files/test.json');
        $lines = $fileReader->readLines();
        $result = '';
        foreach ($lines as $line) {
            $result .= $line;
        }
        $expected = "{\n  \"name\": \"John Doe\",\n  \"age\": 30,\n  \"email\": \"john@example.com\"\n}";
        $this->assertEquals($expected, $result);
    }

    public function testFileNotFoundException()
    {
        $this->expectException(FileNotFoundException::class);
        $fileReader = new FileReader('nonexistent.json');
        $fileReader->read();
    }

    public function testFileNotReadableException()
    {
        if (!\function_exists('chmod')) {
            $this->markTestSkipped('The chmod function is not available.');
        }

        $filename = dirname(__DIR__, 1) . '/test_files/unreadable.json';
        $fileReader = new FileReader($filename);

        // Set the file permissions to 000
        chmod($filename, 000);

        // Try to read the file
        $this->expectException(FileNotReadableException::class);
        $fileReader->read();

        // Set the file permissions back to the default
        chmod($filename, 0644);
    }
}
