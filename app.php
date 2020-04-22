<?php


use Sadiq\CommandHandler;
use Symfony\Component\Console\Application;

require __DIR__ . '/vendor/autoload.php';


$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

$command = new CommandHandler();
$application = new Application();
$application->add($command);
$application->setDefaultCommand($command->getName());
try {
    $application->run();
} catch (Exception $e) {
}