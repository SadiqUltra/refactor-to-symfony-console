<?php

namespace Sadiq;

/**
 * Class CommissionsService
 * @package Sadiq
 */
class CommissionsService extends Service
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
     * @param CurrencyConverterService $currencyConverterService
     */
    public function __construct(ReaderService $readerService, CurrencyConverterService $currencyConverterService)
    {
        parent::__construct();
        $this->readerService = $readerService;
        $this->currencyService = new CurrencyService($readerService, $currencyConverterService);
    }

    /**
     * @return void
     */
    public function loadRates()
    {
        if (!$this->rates) {
            $this->rates = $this->currencyService->getRates();
        }
    }

    /**
     * @param $row
     * @return false|float|string
     */
    public function getCommission($row)
    {
        $jsonRow = $this->readerService->readRow($row);

        if (!$jsonRow) {
            $this->logError('Could Not Read, Stopping execution!', 'critical');
            return 'error';
        }

        $binResults = $this->readerService->readApiToJson(
            getenv('BIN_LIST_API_ENDPOINT') . $jsonRow->bin,
            false
        );

        if (!$binResults) {
            $this->logError('No Result from API, Stopping execution!', 'critical');
            return 'error';
        }

        $isBaseCurrency = $this->currencyService->isBaseCurrency(
            ($binResults->country->alpha2)
        );

        $this->loadRates();
        $rate = isset($this->rates[$jsonRow->currency]) ? $this->rates[$jsonRow->currency] : null;

        if ($isBaseCurrency or $rate == 0) {
            $amntFixed = $jsonRow->amount;
        }
        if (!$isBaseCurrency or $rate > 0) {
            // possibility of divided by zero
            if ($this->rates == 0) {
                $this->logError('Rate = 0, Stopping execution!','critical');
                return 'error';
            }
            $amntFixed = $jsonRow->amount / $rate;
        }

        //    ceil commissions by cents
        return round(
            $amntFixed * ($isBaseCurrency ? 0.01 : 0.02),
            2 // For example, 0.46180... should become 0.47, means two digit
        );
    }
}
