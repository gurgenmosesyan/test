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
        return $price . $cCurrency->$currencyParam;
    }

    public static function partPrice($data, $price, $currencies, $defCurrency, $cCurrency)
    {
        if ($data['currency_id'] != $cCurrency->id) {
            $autoCurrency = $currencies[$data['currency_id']];

            if ($defCurrency->id == $autoCurrency->id) {
                $price = round($price * $cCurrency->rate);
            } else if ($defCurrency->id == $cCurrency->id) {
                $price = round($price / $autoCurrency->rate);
            } else {
                $price = $price / $autoCurrency->rate;
                $price = round($price * $cCurrency->rate);
            }
        }
        return $price . $cCurrency->sign;
    }
}