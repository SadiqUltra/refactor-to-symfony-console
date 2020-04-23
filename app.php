<?php


use Sadiq\CommandHandler;
use Symfony\Component\Console\Application;

require __DIR__ . '/vendor/autoload.php';

// adding ability to manage environment variable
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

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
