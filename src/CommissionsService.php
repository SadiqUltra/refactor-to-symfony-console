<?php

namespace Sadiq;
/**
 * Class CommissionsService
 * @package Sadiq
 */
class CommissionsService
{
    /**
     * @var ReaderService
     */
    private $readerService;
    /**
     * @var CurrencyService
     */
    private $currencyService;
    /**
     * @var array|null
     */
    private $rates;

    /**
     * CommissionsService constructor.
     * @param ReaderService $readerService
     */
    public function __construct(ReaderService $readerService)
    {
        $this->readerService = $readerService;
        $this->currencyService = new CurrencyService($readerService);
        $this->rates = $this->currencyService->getRates();

//        var_dump($this->rates);
    }

    /**
     * @param $row
     * @return false|float|void|null
     */
    public function getCommission($row)
    {
        $jsonRow = $this->readerService->readRow($row);

        // not phpunit test able
//        if (!$jsonRow) die('error!');

        if (!$jsonRow) return null;

        $binResults = $this->readerService->readBinList($jsonRow->bin);

        // not phpunit test able
//        if (!$binResults) die('error!');

        if (!$binResults) return null;

        //$isEu
        $isBaseCurrency = $this->currencyService->isBaseCurrency(
            ($binResults->country->alpha2)
        );

        $rate = isset($this->rates[$jsonRow->currency]) ? $this->rates[$jsonRow->currency] : null;

        if ($isBaseCurrency or $rate == 0) {
            $amntFixed = $jsonRow->amount;
        }
        if (!$isBaseCurrency or $rate > 0) {
            // possibility of divided by zero
            if ($this->rates == 0) {
                $this->readerService->log->error('Rate = 0');
                return;
            }
            $amntFixed = $jsonRow->amount / $rate;
        }

        // reduced unnecessary comparison
        //    ceil commissions by cents
        return round(
            $amntFixed * ($isBaseCurrency ? 0.01 : 0.02),
            2 // For example, 0.46180... should become 0.47, means two digit
        );

    }


}
