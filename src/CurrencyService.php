<?php
namespace Sadiq;

class CurrencyService {

    private $readerService;

    public function __construct(ReaderService $readerService)
    {
        $this->readerService = $readerService;
    }

    public function isBaseCurrency($currency){
        $currencyDataJson = $this->readerService->readCurrencyData();

        if (isset($currencyDataJson->$currency) && $currencyDataJson->$currency === getenv('BASE_CURRENCY')){
            return true;
        }

        return false;
    }
}
