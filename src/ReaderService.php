<?php

namespace Sadiq;

use Exception;
use Symfony\Component\Filesystem\Filesystem;

/**
 * Class ReaderService
 * @package Sadiq
 */
class ReaderService extends Service
{

    /**
     * @var Filesystem
     */
    private $filesystem;

    /**
     * ReaderService constructor.
     */
    public function __construct()
    {
        parent::__construct();
        $this->filesystem = new Filesystem();
    }

    /**
     * @param $fileName
     * @param bool $assoc
     * @return mixed|null
     */
    public function readFileToJson($fileName, $assoc = false)
    {
        $rawJson = $this->readFile($fileName);
        try {
            $data = json_decode($rawJson, $assoc);

            if (json_last_error() !== JSON_ERROR_NONE) {
                throw new Exception('Not Valid JSON: '.json_last_error_msg());
            }
            return $data;
        } catch (Exception $exception) {
            $this->logError($exception->getMessage());
            return null;
        }
    }

    /**
     * @param $fileName
     * @return false|string|null
     */
    public function readFile($fileName)
    {
        if ($this->filesystem->exists($fileName)) {
            return file_get_contents($fileName);
        } else {
            $this->logError($fileName . ', not found');
            return null;
        }
    }

    /**
     * @param $apiEndPoint
     * @param bool $assoc
     * @return mixed|null
     */
    public function readApiToJson($apiEndPoint, $assoc = true)
    {
        try {
            $data = json_decode(
                file_get_contents($apiEndPoint),
                $assoc
            );

            if (json_last_error() !== JSON_ERROR_NONE) {
                throw new Exception('Not Valid JSON: '.json_last_error_msg());
            }

            return $data;
        } catch (Exception $exception) {
            $this->logError($exception->getMessage());
            return null;
        }
    }

    /**
     * @param $fileName
     * @return array
     */
    public function readInputFile($fileName)
    {
        return explode("\n", $this->readFile($fileName));
    }

    /**
     * @param $row
     * @return mixed
     */
    public function readRow($row)
    {
        try {
            $jsonRow = json_decode($row);
            if (json_last_error() !== JSON_ERROR_NONE) {
                throw new Exception('Not Valid JSON: '.json_last_error_msg());
            }
            return $jsonRow;
        } catch (Exception $exception) {
            $this->logError($exception->getMessage());
            return null;
        }
    }
}
