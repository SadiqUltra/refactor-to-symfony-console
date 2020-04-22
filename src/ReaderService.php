<?php
namespace Sadiq;
use Symfony\Component\Filesystem\Exception\IOExceptionInterface;
use Symfony\Component\Filesystem\Filesystem;

class ReaderService {

    private $filesystem;

    public function __construct()
    {
        $this->filesystem = new Filesystem();
    }

    public function readCurrencyData(){
        $fileName = getenv('CURRENCY_DATA_FILE');
        if ($this->filesystem->exists($fileName)){
            $rawJson = file_get_contents($fileName);

            return json_decode($rawJson);
        }else{
//            log error, no currency data found
        }
    }

}
