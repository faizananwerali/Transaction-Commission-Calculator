<?php

use App\Commands\CommandFactory;
use App\Services\Application;
use App\Services\Config;
use App\Services\EnvLoader;
use App\Interfaces\CommandInterface;
use App\Interfaces\ApplicationInterface;

class ApplicationTest extends PHPUnit\Framework\TestCase
{
    protected Application $app;

    protected function setUp(): void
    {
        parent::setUp();
        EnvLoader::load(dirname(__DIR__, 3));
        Config::load(dirname(__DIR__, 3));
        $this->app = new Application();
    }

    public function testApplicationRun()
    {
        // Create a mock Command object
        $command = $this->getMockBuilder(CommandInterface::class)
            ->getMock();

        // Create a mock CommandFactory object that returns the mock Command object
        $factory = $this->getMockBuilder(CommandFactory::class)
            ->getMock();
        $factory
            ->method('createCommand')
            ->willReturn($command);

        // Set the mock CommandFactory object in the Application object
//        $reflection = new ReflectionClass($this->app);
//        $property = $reflection->getProperty('factory');
//        $property->setAccessible(true);
//        $property->setValue($this->app, $factory);

        // Set the command line arguments
        $argv = ['index.php', dirname(__DIR__, 1) . '/test_files/input.txt'];

        // Call the run method of the Application object
        $this->expectOutputString("1\n0.47\n1.36\n2.4\n45.89");
        $this->app->run($argv);
    }

//    public function testApplicationRunWithException()
//    {
//        // Create a mock Command object that throws an exception
////        $exception = new InvalidArgumentException("File 'filename' not found.");
////        $command = $this->getMockBuilder(CommandInterface::class)
////            ->getMock();
////        $command->expects($this->once())
////            ->method('execute')
////            ->willThrowException($exception);
////
////        // Create a mock CommandFactory object that returns the mock Command object
////        $factory = $this->getMockBuilder(CommandFactory::class)
////            ->getMock();
////        $factory
////            ->method('createCommand')
////            ->willReturn($command);
//
//        // Set the mock CommandFactory object in the Application object
////        $reflection = new ReflectionClass($this->app);
////        $property = $reflection->getProperty('factory');
////        $property->setAccessible(true);
////        $property->setValue($this->app, $factory);
//
//        // Set the command line arguments
//        $argv = ['index.php'];
//
//        // Call the run method of the Application object and expect the exception to be thrown
//        //$this->expectException(InvalidArgumentException::class);
//        //$this->expectExceptionMessage("");
//        //$this->expectOutputString('');
//        $this->app->run($argv);
//    }
}
