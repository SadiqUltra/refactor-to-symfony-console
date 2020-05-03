<?php

namespace Sadiq;

/**
 * Class CurrencyConverterService
 * @package Sadiq
 */
class CurrencyConverterService
{

    /**
     * @param $tmpRates
     * @param $baseOfExchange
     * @return array|null
     */
    public function convertRates($tmpRates, $baseOfExchange)
    {
        $definedBase = getenv('BASE_CURRENCY');

        if (strcasecmp($baseOfExchange, $definedBase) == 0) {
            return $tmpRates;
        }

        if (!isset($tmpRates[$definedBase])) {
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
