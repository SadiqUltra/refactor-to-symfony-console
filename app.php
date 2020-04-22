<?php


use Sadiq\CommandHandler;
use Symfony\Component\Console\Application;
use Monolog\Logger;
use Monolog\Handler\StreamHandler;

require __DIR__ . '/vendor/autoload.php';


$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();
// create a log channel
$log = new Logger('name');
$log->pushHandler(new StreamHandler('app.log', Logger::WARNING));


$command = new CommandHandler();
$application = new Application();
$application->add($command);
$application->setDefaultCommand($command->getName(), true);
try {
    $application->run();
} catch (Exception $e) {
}