<?php

namespace Sadiq;

use Exception;
use Symfony\Component\Filesystem\Filesystem;

/**
 * Class ReaderService
 * @package Sadiq
 */
class ReaderService
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
        $this->filesystem = new Filesystem();
    }

    /**
     * @return mixed
     */
    public function readCurrencyData()
    {
        $fileName = getenv('CURRENCY_DATA_FILE');
        $rawJson = $this->readFile($fileName);
        return json_decode($rawJson);
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
            logError('ReaderService', $fileName . ', not found');
            // not phpunit test able
//            die('error!');
            return null;
        }
    }

    /**
     * @return mixed|null
     */
    public function readRates()
    {
        return $this->readApiToJson(getenv('RATES_API_ENDPOINT'));
    }

    /**
     * @param $apiEndPoint
     * @param bool $assoc
     * @return mixed|null
     */
    public function readApiToJson($apiEndPoint, $assoc = true)
    {
        try {
            return $rates = @json_decode(file_get_contents($apiEndPoint), $assoc);
        } catch (Exception $exception) {
            logError('ReaderService', $exception->getMessage());
            // not phpunit test able
//            die('error!');
            return null;
        }
    }

    /**
     * @param $bin
     * @return mixed|null
     */
    public function readBinList($bin)
    {
        return $this->readApiToJson(getenv('BIN_LIST_API_ENDPOINT') . $bin, false);
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
        // json Exception
        try {
            return $jsonRow = json_decode($row);
        } catch (Exception $exception) {
            logError('ReaderService', $exception->getMessage());
        }
    }
}
