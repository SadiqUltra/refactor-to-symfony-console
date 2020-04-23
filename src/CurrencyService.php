<?php

namespace Sadiq;

/**
 * Class CurrencyService
 * @package Sadiq
 */
class CurrencyService
{

    /**
     * @var ReaderService
     */
    private $readerService;

    /**
     * CurrencyService constructor.
     * @param ReaderService $readerService
     */
    public function __construct(ReaderService $readerService)
    {
        $this->readerService = $readerService;
    }

    /**
     * @param $currency
     * @return bool
     */
    public function isBaseCurrency($currency)
    {
        $currencyDataJson = $this->readerService->readCurrencyData();

        if (isset($currencyDataJson->$currency) && $currencyDataJson->$currency === getenv('BASE_CURRENCY')) {
            return true;
        }

        return false;
    }

    /**
     * @return array|null
     */
    public function getRates()
    {
        $jsonExchangeRates = $this->readerService->readRates();
        $baseOfExchange = $jsonExchangeRates['base'];

        $definedBase = getenv('BASE_CURRENCY');

        $tmpRates = $jsonExchangeRates['rates'];

//        var_dump($tmpRates);

        if (strcasecmp($baseOfExchange, $definedBase) == 0) {
            return $tmpRates;
        }

        if (!isset($tmpRates[$definedBase])) {
            // not phpunit test able
//            die('error');
            return null;
        }

        $rates = [];
        $rateOfBase = $tmpRates[$definedBase];


        $rates[$baseOfExchange] = 1 / $rateOfBase;

        foreach ($tmpRates as $key => $rate) {
            if (strcasecmp($key, $definedBase) == 0) {
                continue;
            }
            $rates[$key] = $rate / $rateOfBase;
        }

        return $rates;
    }
}
