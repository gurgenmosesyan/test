<?php

namespace App\Helpers;

use App\Models\Currency\CurrencyManager;

class Base
{
    public static function price($auto)
    {
        $currencyManager = new CurrencyManager();
        $currencies = $currencyManager->all();
        $defCurrency = $currencyManager->defaultCurrency();
        $cCurrency = $currencyManager->currentCurrency();

        if ($auto['currency_id'] == $cCurrency->id) {
            $price = $auto['price'];
        } else {
            $autoCurrency = $currencies[$auto['currency_id']];

            if ($defCurrency->id == $autoCurrency->id) {
                $price = round($auto['price'] * $cCurrency->rate);
            } else if ($defCurrency->id == $cCurrency->id) {
                $price = round($auto['price'] / $autoCurrency->rate);
            } else {
                $price = $auto['price'] / $autoCurrency->rate;
                $price = round($price * $cCurrency->rate);
            }
        }
        return $price . ' ' . $cCurrency->code;
    }
}