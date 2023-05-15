<?php

use App\Commands\HelpCommand;
use PHPUnit\Framework\TestCase;

class HelpCommandTest extends TestCase
{
    public function testExecute()
    {
        // Create a new HelpCommand instance
        $command = new HelpCommand();
        $this->expectOutputRegex('/Usage:/');
        // Execute the command and verify that the output is correct.
        $command->execute();
    }

    public function testExecuteWithException()
    {
        // Create a new HelpCommand instance and set shouldThrowException to true.
        $command = new HelpCommand();
        $command->setShouldThrowException(true);
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessageMatches('/Usage:/');
        // Execute the command and verify that the output is correct.
        $command->execute();
    }
}
