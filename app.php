<?php


use Monolog\Handler\StreamHandler;
use Monolog\Logger;
use Sadiq\CommandHandler;
use Symfony\Component\Console\Application;

require __DIR__ . '/vendor/autoload.php';

// adding ability to manage environment variable
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

function logError($className, $message, $arg=[]){
    (new Logger($className))
        ->pushHandler(new StreamHandler(__DIR__ . getenv('LOG_FILE'), Logger::ERROR))
        ->error($message, $arg)
    ;
}

// main command file
$command = new CommandHandler();
$application = new Application();
$application->add($command);

// a single command application
$application->setDefaultCommand($command->getName(), true);
try {
    $application->run();
} catch (Exception $e) {
}
