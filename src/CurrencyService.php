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

        $currencyConverterService = new CurrencyConverterService();

        return $currencyConverterService->convertRates(
            $jsonExchangeRates['rates'],
            $jsonExchangeRates['base']
        );
    }
}
