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
     * @var CurrencyConverterService
     */
    private $currencyConverterService;

    /**
     * CurrencyService constructor.
     * @param ReaderService $readerService
     * @param CurrencyConverterService $currencyConverterService
     */
    public function __construct(ReaderService $readerService, CurrencyConverterService $currencyConverterService)
    {
        $this->readerService = $readerService;
        $this->currencyConverterService = $currencyConverterService;
    }

    /**
     * @param $currency
     * @return bool
     */
    public function isBaseCurrency($currency)
    {
        $currencyDataFileName = getenv('CURRENCY_DATA_FILE');
        $currencyDataJson = $this->readerService->readFileToJson($currencyDataFileName);

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
        $jsonExchangeRates = $this->readerService->readApiToJson(getenv('RATES_API_ENDPOINT'));

        return $this->currencyConverterService->convertRates(
            $jsonExchangeRates['rates'],
            $jsonExchangeRates['base']
        );
    }
}
