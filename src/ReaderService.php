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
        $rawJson = $this->readFile($fileName);
        return json_decode($rawJson);
    }

    public function readRates(){
            return $this->readApiToJson(getenv('RATES_API_ENDPOINT'))['rates'];
    }

    public function readBinList($bin){
        return $this->readApiToJson(getenv('BIN_LIST_API_ENDPOINT') . $bin);
    }

    public function readInputFile($fileName){
            return explode("\n", $this->readFile($fileName));
    }

    public function readFile($fileName){
        if ($this->filesystem->exists($fileName)){
            return file_get_contents($fileName);
        }else{
            $this->log->error($fileName .', not found');
            die('error!');
        }
    }

    public function readApiToJson($apiEndPoint){
        try{
            return $rates = @json_decode(file_get_contents($apiEndPoint), true);
        }catch (\Exception $exception){
            $this->log->error($exception->getMessage());
            die('error!');
        }

    }


}
