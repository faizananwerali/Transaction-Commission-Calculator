<?php

namespace Tests\App\Commands;

use App\Commands\CommandFactory;
use App\Interfaces\CommandInterface;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;

class CommandFactoryTest extends TestCase
{
    private CommandFactory $factory;

    protected function setUp(): void
    {
        parent::setUp();
        $this->factory = new CommandFactory();
    }

    public function testCreateCommandReturnsCommissionCommandWhenTwoArgumentsProvided(): void
    {
        $filename = 'test.txt';
        $arguments = ['filename.php', $filename];

        $command = $this->factory->createCommand($arguments);

        $this->assertInstanceOf(CommandInterface::class, $command);
        $this->assertSame($filename, $command->filename);
    }

    public function testCreateCommandThrowsInvalidArgumentExceptionWhenIncorrectNumberOfArgumentsProvided(): void
    {
        $arguments = ['filename.php'];
        $this->expectException(InvalidArgumentException::class);

        $this->factory->createCommand($arguments);
    }

    public function testCreateCommandShowsHelpAndExitsWhenHelpFlagProvided(): void
    {
        $arguments = ['filename.php', '--help'];
        $this->expectOutputRegex('/Usage:/');

        $this->factory->createCommand($arguments);
    }

    public function testCreateCommandShowsHelpAndExitsWhenHFlagProvided(): void
    {
        $arguments = ['filename.php', '-h'];
        $this->expectOutputRegex('/Usage:/');

        $this->factory->createCommand($arguments);
    }
}
