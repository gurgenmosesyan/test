<?php

namespace App\Helpers;

class Base
{
    public static function price($data, $currencies, $defCurrency, $cCurrency, $currencyParam = 'sign')
    {
        if ($data->currency_id == $cCurrency->id) {
            $price = $data->price;
        } else {
            $autoCurrency = $currencies[$data->currency_id];

            if ($defCurrency->id == $autoCurrency->id) {
                $price = round($data->price * $cCurrency->rate);
            } else if ($defCurrency->id == $cCurrency->id) {
                $price = round($data->price / $autoCurrency->rate);
            } else {
                $price = $data->price / $autoCurrency->rate;
                $price = round($price * $cCurrency->rate);
            }
        }
        return number_format($price, 0, '.', '.') . $cCurrency->{$currencyParam};
    }

    public static function calcPrice($currencyId, $price, $currencies, $defCurrency, $cCurrency)
    {
        if ($currencyId != $cCurrency->id) {
            $autoCurrency = $currencies[$currencyId];

            if ($defCurrency->id == $autoCurrency->id) {
                $price = round($price * $cCurrency->rate);
            } else if ($defCurrency->id == $cCurrency->id) {
                $price = round($price / $autoCurrency->rate);
            } else {
                $price = $price / $autoCurrency->rate;
                $price = round($price * $cCurrency->rate);
            }
        }
        return $price;
    }
}