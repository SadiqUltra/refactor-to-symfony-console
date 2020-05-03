<?php


namespace Sadiq;

use Monolog\Handler\StreamHandler;
use Monolog\Logger;

class Service
{
    /**
     * @var Logger
     */
    private $logger;

    public function __construct()
    {
        $this->logger = new Logger(
            get_class($this)
        );
        $this->logger->pushHandler(
            new StreamHandler(__DIR__ . getenv('LOG_FILE'), Logger::ERROR)
        );
    }

    /**
     * @param string $message
     * @param string $level
     * @param array $arg
     */
    public function logError($message, $level='error', $arg=[])
    {
        $this->logger->$level($message, $arg);
    }
}
