<?php


use PHPUnit\Framework\TestCase;
use Sadiq\ReaderService;

class ReaderServiceTest extends TestCase
{
    public function testApiLoading()
    {
        $readerService = new ReaderService();
        $this->assertTrue(null !== $readerService->readApiToJson('tests/offlineData/exchangeratesapi.json'));
    }

    public function testApiLoadingErrorUrl()
    {
        $readerService = new ReaderService();
        $this->assertTrue(null == $readerService->readApiToJson('tests/offlineData/errorrr.json'));
    }


    public function testReadFile()
    {
        $readerService = new ReaderService();
        $this->assertTrue(null !== $readerService->readApiToJson('data/currency.json'));
    }


    public function testReadFileErrorPath()
    {
        $readerService = new ReaderService();
        $this->assertFalse(null !== $readerService->readApiToJson('data/errorrr.json'));
    }

    public function testRates()
    {
        putenv('RATES_API_ENDPOINT=' . __DIR__ . '/../offlineData/exchangeratesapi.json');
        putenv("BASE_CURRENCY=EUR");
        putenv("CURRENCY_DATA_FILE=data/currency.json");
        $readerService = new ReaderService();
        $this->assertTrue(null !== $readerService->readRates());
    }
}
