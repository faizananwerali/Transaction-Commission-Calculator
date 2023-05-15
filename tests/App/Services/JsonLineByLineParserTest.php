<?php

namespace App\Tests\Services;

use App\Exceptions\FileNotFoundException;
use App\Services\FileReader;
use App\Services\JsonLineByLineParser;
use PHPUnit\Framework\TestCase;
use PHPUnit\Util\InvalidJsonException;
use stdClass;

/**
 * JsonLineByLineParserTest tests the JsonLineByLineParser class.
 */
class JsonLineByLineParserTest extends TestCase
{
    /**
     * @var array The expected parsed objects.
     */
    private array $expectedParsedObjects = [];

    /**
     * Sets up the test environment.
     */
    protected function setUp(): void
    {
        $object1 = new stdClass();
        $object1->bin = '45717360';
        $object1->amount = '100.00';
        $object1->currency = 'EUR';

        $object2 = new stdClass();
        $object2->bin = '516793';
        $object2->amount = '50.00';
        $object2->currency = 'USD';

        $object3 = new stdClass();
        $object3->bin = '45417360';
        $object3->amount = '10000.00';
        $object3->currency = 'JPY';

        $object4 = new stdClass();
        $object4->bin = '41417360';
        $object4->amount = '130.00';
        $object4->currency = 'USD';

        $object5 = new stdClass();
        $object5->bin = '4745030';
        $object5->amount = '2000.00';
        $object5->currency = 'GBP';

        $this->expectedParsedObjects = [
            $object1,
            $object2,
            $object3,
            $object4,
            $object5,
        ];
    }

    /**
     * Tests that the `parseJson()` method parses the JSON file correctly.
     */
    public function testParseJson(): void
    {
        $fileReader = new FileReader(dirname(__DIR__, 1) . '/test_files/input.txt');
        $jsonLineByLineParser = new JsonLineByLineParser($fileReader);

        $parsedObjects = iterator_to_array($jsonLineByLineParser->parseJson());

        $this->assertEquals($this->expectedParsedObjects, $parsedObjects);
    }

    /**
     * Tests that the `parseJson()` method throws an exception if invalid JSON is found in the file.
     */
    public function testParseJsonWithInvalidJson(): void
    {
        $this->expectException(InvalidJsonException::class);

        $fileReader = new FileReader(dirname(__DIR__, 1) . '/test_files/invalid_input.txt');
        $jsonLineByLineParser = new JsonLineByLineParser($fileReader);

        foreach ($jsonLineByLineParser->parseJson() as $parsedObject) {
            // Do nothing.
        }
    }
}