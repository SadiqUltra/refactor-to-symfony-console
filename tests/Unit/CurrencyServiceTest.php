<?php


use PHPUnit\Framework\TestCase;
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
        $currencyService = new CurrencyService($readerService);

        $this->assertTrue($currencyService->isBaseCurrency("AT"));
    }


    public function testIsBaseCurrencyBD()
    {
        putenv('RATES_API_ENDPOINT=' . __DIR__ . '/../offlineData/exchangeratesapi.json');
        putenv("BASE_CURRENCY=EUR");
        putenv("CURRENCY_DATA_FILE=data/currency.json");
        $readerService = new ReaderService();
        $currencyService = new CurrencyService($readerService);

        $this->assertFalse($currencyService->isBaseCurrency("BD"));
    }

    public function testRatesEUR()
    {
        putenv('RATES_API_ENDPOINT=' . __DIR__ . '/../offlineData/exchangeratesapi.json');
        putenv("BASE_CURRENCY=EUR");
        putenv("CURRENCY_DATA_FILE=data/currency.json");
        $readerService = new ReaderService();
        $currencyService = new CurrencyService($readerService);

        $this->assertTrue(null != $currencyService->getRates());
    }

    public function testRatesBDT()
    {
        putenv('RATES_API_ENDPOINT=' . __DIR__ . '/../offlineData/exchangeratesapi.json');
        putenv("BASE_CURRENCY=BDT");
        putenv("CURRENCY_DATA_FILE=data/currency.json");
        $readerService = new ReaderService();
        $currencyService = new CurrencyService($readerService);

        $this->assertTrue(null == $currencyService->getRates());
    }
}
