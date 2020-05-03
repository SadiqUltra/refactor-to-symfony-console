<?php


use PHPUnit\Framework\TestCase;
use Sadiq\CurrencyConverterService;
use Sadiq\CurrencyService;
use Sadiq\ReaderService;

class CurrencyServiceTest extends TestCase
{
    public function testIsBaseCurrencyAT()
    {
        putenv('RATES_API_ENDPOINT=' . __DIR__ . '/../offlineData/exchangeratesapi.json');
        putenv("BASE_CURRENCY=EUR");
        putenv("CURRENCY_DATA_FILE=data/currency.json");
        $readerService = new ReaderService();
        $currencyConverterService = new CurrencyConverterService();
        $currencyService = new CurrencyService($readerService, $currencyConverterService);

        $this->assertTrue($currencyService->isBaseCurrency("AT"));
    }


    public function testIsBaseCurrencyBD()
    {
        putenv('RATES_API_ENDPOINT=' . __DIR__ . '/../offlineData/exchangeratesapi.json');
        putenv("BASE_CURRENCY=EUR");
        putenv("CURRENCY_DATA_FILE=data/currency.json");
        $readerService = new ReaderService();
        $currencyConverterService = new CurrencyConverterService();
        $currencyService = new CurrencyService($readerService, $currencyConverterService);

        $this->assertFalse($currencyService->isBaseCurrency("BD"));
    }

    public function testRatesEUR()
    {
        putenv('RATES_API_ENDPOINT=' . __DIR__ . '/../offlineData/exchangeratesapi.json');
        putenv("BASE_CURRENCY=EUR");
        putenv("CURRENCY_DATA_FILE=data/currency.json");
        $readerService = new ReaderService();
        $currencyConverterService = new CurrencyConverterService();
        $currencyService = new CurrencyService($readerService, $currencyConverterService);

        $this->assertTrue(null != $currencyService->getRates());
    }

    public function testRatesBDT()
    {
        putenv('RATES_API_ENDPOINT=' . __DIR__ . '/../offlineData/exchangeratesapi.json');
        putenv("BASE_CURRENCY=BDT");
        putenv("CURRENCY_DATA_FILE=data/currency.json");
        $readerService = new ReaderService();
        $currencyConverterService = new CurrencyConverterService();
        $currencyService = new CurrencyService($readerService, $currencyConverterService);

        $this->assertTrue(null == $currencyService->getRates());
    }
}
