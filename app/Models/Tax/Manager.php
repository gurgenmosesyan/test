<?php

namespace App\Models\Tax;

use App\Helpers\Base;
use App\Models\Currency\CurrencyManager;
use App\Models\Config\Config;
use App\Models\Config\Manager as ConfManager;
use Cache;

class Manager
{
    public static function calculate(Tax $tax)
    {
        $result = [];
        $currencyManager = new CurrencyManager();
        $currencies = $currencyManager->all();
        $defCurrency = $currencyManager->defaultCurrency();
        $cCurrency = $currencyManager->currentCurrency();
        $sign = $cCurrency->sign;

        $age = date('Y') - $tax->year;
        if ($age <= 5) {
            $percent = 32;
        } else if ($age <= 10) {
            $percent = 34;
        } else if ($age <= 15) {
            $percent = 42;
        } else {
            $percent = 52;
        }
        $taxPrice = $tax->price * $percent / 100;
        $result['price'] = Base::calcPrice($tax->currency_id, $taxPrice, $currencies, $defCurrency, $cCurrency);
        $conf = ConfManager::getTaxData();
        $currencyId = $conf[Config::KEY_TAX_CURRENCY]->value;
        $customsPrice = $tax->body == Tax::BODY_PASSENGER ? $conf[Config::KEY_TAX_PASSENGER_PRICE]->value : $conf[Config::KEY_TAX_TRUCK_PRICE]->value;
        $result['customs'] = Base::calcPrice($currencyId, $customsPrice, $currencies, $defCurrency, $cCurrency);
        $result['rename'] = Base::calcPrice($currencyId, $conf[Config::KEY_TAX_RENAME_PRICE]->value, $currencies, $defCurrency, $cCurrency);
        $result['passport'] = Base::calcPrice($currencyId, $conf[Config::KEY_TAX_PASSPORT_PRICE]->value, $currencies, $defCurrency, $cCurrency);
        $result['number'] = Base::calcPrice($currencyId, $conf[Config::KEY_TAX_NUMBER_PRICE]->value, $currencies, $defCurrency, $cCurrency);
        $result['nullification'] = trans('www.tax.nullification.price');
        $result['total'] = $result['price'] + $result['customs'] + $result['rename'] + $result['passport'] + $result['number'];
        $result['price'] = number_format($result['price'], 0, '', '.') . $sign;
        $result['customs'] = number_format($result['customs'], 0, '', '.') . $sign;
        $result['rename'] = number_format($result['rename'], 0, '', '.') . $sign;
        $result['passport'] = number_format($result['passport'], 0, '', '.') . $sign;
        $result['number'] = number_format($result['number'], 0, '', '.') . $sign;
        $result['total'] = number_format($result['total'], 0, '', '.') . $sign;
        return $result;
    }

    /**************************************/

    public function store($data)
    {
        $tax = new Tax($data);
        $tax->save();
    }

    public function update($id, $data)
    {
        $tax = Tax::where('id', $id)->firstOrFail();
        $tax->update($data);
    }

    public function delete($id)
    {
        Tax::where('id', $id)->delete();
    }
}