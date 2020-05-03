<?php


use PHPUnit\Framework\TestCase;
use Sadiq\CommissionsService;
use Sadiq\CurrencyConverterService;
use Sadiq\ReaderService;

class CommissionsServiceTest extends TestCase
{
    public function testInputTxtResult1()
    {
        putenv('RATES_API_ENDPOINT=' . __DIR__ . '/../offlineData/exchangeratesapi.json');
        putenv("BIN_LIST_API_ENDPOINT=" . __DIR__ . "/../offlineData/bin/");
        putenv("BASE_CURRENCY=EUR");
        putenv("CURRENCY_DATA_FILE=data/currency.json");
        $readerService = new ReaderService();
        $currencyConverterService = new CurrencyConverterService();
        $commissionService = new CommissionsService($readerService, $currencyConverterService);

        $this->assertTrue(1 == $commissionService->getCommission('{"bin":"45717360","amount":"100.00","currency":"EUR"}'));
    }


    public function testInputTxtResult2()
    {
        putenv('RATES_API_ENDPOINT=' . __DIR__ . '/../offlineData/exchangeratesapi.json');
        putenv("BIN_LIST_API_ENDPOINT=" . __DIR__ . "/../offlineData/bin/");
        putenv("BASE_CURRENCY=EUR");
        putenv("CURRENCY_DATA_FILE=data/currency.json");
        $readerService = new ReaderService();
        $currencyConverterService = new CurrencyConverterService();
        $commissionService = new CommissionsService($readerService, $currencyConverterService);

        $this->assertTrue(45.39 == $commissionService->getCommission('{"bin":"4745030","amount":"2000.00","currency":"GBP"}'));
    }


    public function testBinError()
    {
        putenv("ENV=TEST");

        putenv('RATES_API_ENDPOINT=' . __DIR__ . '/../offlineData/exchangeratesapi.json');
        putenv("BIN_LIST_API_ENDPOINT=" . __DIR__ . "/../offlineData/bin/");
        putenv("BASE_CURRENCY=EUR");
        putenv("CURRENCY_DATA_FILE=data/currency.json");
        $readerService = new ReaderService();
        $currencyConverterService = new CurrencyConverterService();
        $commissionService = new CommissionsService($readerService, $currencyConverterService);

        $this->assertTrue('error' == $commissionService->getCommission('{"bin":"45717353453460","amount":"100.00","currency":"EUR"}'));
    }

    public function testCurrencyCAD()
    {
        putenv('RATES_API_ENDPOINT=' . __DIR__ . '/../offlineData/exchangeratesapi.json');
        putenv("BIN_LIST_API_ENDPOINT=" . __DIR__ . "/../offlineData/bin/");
        putenv("BASE_CURRENCY=CAD");
        putenv("CURRENCY_DATA_FILE=data/currency.json");
        $readerService = new ReaderService();
        $currencyConverterService = new CurrencyConverterService();
        $commissionService = new CommissionsService($readerService, $currencyConverterService);

        $this->assertTrue(3.08 == $commissionService->getCommission('{"bin":"45717360","amount":"100.00","currency":"EUR"}'));
    }

    public function testRatesError()
    {
        putenv('RATES_API_ENDPOINT=' . __DIR__ . '/../offlineData/exchangeratesapi.json');
        putenv("BIN_LIST_API_ENDPOINT=" . __DIR__ . "/../offlineData/bin/");
        putenv("BASE_CURRENCY=BDT");
        putenv("CURRENCY_DATA_FILE=data/currency.json");
        $readerService = new ReaderService();
        $currencyConverterService = new CurrencyConverterService();
        $commissionService = new CommissionsService($readerService, $currencyConverterService);

        $this->assertTrue('error' == $commissionService->getCommission('{"bin":"45717353453460","amount":"100.00","currency":"EUR"}'));
    }
}
