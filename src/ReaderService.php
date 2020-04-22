<?php
namespace Sadiq;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;
use Symfony\Component\Filesystem\Exception\IOExceptionInterface;
use Symfony\Component\Filesystem\Filesystem;

class ReaderService {

    private $filesystem;
    private $log;

    public function __construct()
    {
        $this->filesystem = new Filesystem();
        // create a log channel
        $this->log = new Logger('ReaderService');
        $this->log->pushHandler(new StreamHandler(getenv('LOG_FILE'), Logger::WARNING));
    }

    public function readCurrencyData(){
        $fileName = getenv('CURRENCY_DATA_FILE');
        if ($this->filesystem->exists($fileName)){
            $rawJson = file_get_contents($fileName);
            return json_decode($rawJson);
        }else{
            $this->log->error('CURRENCY_DATA_FILE: '. $fileName .', not found');
        }
    }

    public function readRates(){
            return $this->readApiToJson(getenv('RATES_API_ENDPOINT'))['rates'];
    }

    public function readBinList($bin){
        return $this->readApiToJson(getenv('BIN_LIST_API_ENDPOINT') . $bin);
    }

    public function readApiToJson($apiEndPoint){
        try{
            return $rates = @json_decode(file_get_contents($apiEndPoint), true);
        }catch (\Exception $exception){
            $this->log->error($exception->getMessage());
        }

    }

    public function readInputFile($fileName){
        if ($this->filesystem->exists($fileName)){
            return explode("\n", file_get_contents($fileName));
        }else{
            $this->log->error($fileName .', not found');
            die;
        }
    }
}
