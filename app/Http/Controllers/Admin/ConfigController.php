<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Core\BaseController;
use App\Models\Config\Config;
use App\Models\Config\Manager;
use App\Http\Requests\Admin\ConfigRequest;
use App\Core\Language\Language;
use App\Models\Currency\Currency;

class ConfigController extends BaseController
{
    protected $manager = null;

    public function __construct(Manager $manager)
    {
        $this->manager = $manager;
    }

    public function edit()
    {
        $configs = Config::all();
        $logo = null;
        $watermark = null;
        $autoEmpty = null;
        $taxPassengerPrice = $taxTruckPrice = $taxCurrency = null;
        $taxRenamePrice = $taxPassportPrice = $taxNumberPrice = null;
        $priceTopPerDay = $priceUrgentPerDay = $priceAdPerDay = null;
        foreach ($configs as $config) {
            if ($config->key == Config::KEY_LOGO) {
                $logo = $config;
            } else if ($config->key == Config::KEY_AUTO_EMPTY) {
                $autoEmpty = $config->value;
            } else if ($config->key == Config::KEY_WATERMARK) {
                $watermark = $config->value;
            } else if ($config->key == Config::KEY_TAX_PASSENGER_PRICE) {
                $taxPassengerPrice = $config->value;
            } else if ($config->key == Config::KEY_TAX_TRUCK_PRICE) {
                $taxTruckPrice = $config->value;
            } else if ($config->key == Config::KEY_TAX_RENAME_PRICE) {
                $taxRenamePrice = $config->value;
            } else if ($config->key == Config::KEY_TAX_PASSPORT_PRICE) {
                $taxPassportPrice = $config->value;
            } else if ($config->key == Config::KEY_TAX_NUMBER_PRICE) {
                $taxNumberPrice = $config->value;
            } else if ($config->key == Config::KEY_TAX_CURRENCY) {
                $taxCurrency = $config->value;
            } else if ($config->key == Config::KEY_PRICE_TOP_PER_DAY) {
                $priceTopPerDay = $config->value;
            } else if ($config->key == Config::KEY_PRICE_URGENT_PER_DAY) {
                $priceUrgentPerDay = $config->value;
            } else if ($config->key == Config::KEY_PRICE_AD_PER_DAY) {
                $priceAdPerDay = $config->value;
            }
        }
        $currencies = Currency::active()->ordered()->get();
        return view('admin.config.edit')->with([
            'logo' => $logo,
            'watermark' => $watermark,
            'autoEmpty' => $autoEmpty,
            'taxPassengerPrice' => $taxPassengerPrice,
            'taxTruckPrice' => $taxTruckPrice,
            'taxRenamePrice' => $taxRenamePrice,
            'taxPassportPrice' => $taxPassportPrice,
            'taxNumberPrice' => $taxNumberPrice,
            'taxCurrency' => $taxCurrency,
            'priceTopPerDay' => $priceTopPerDay,
            'priceUrgentPerDay' => $priceUrgentPerDay,
            'priceAdPerDay' => $priceAdPerDay,
            'languages' => Language::all(),
            'currencies' => $currencies
        ]);
    }

    public function update(ConfigRequest $request)
    {
        $this->manager->update($request->all());
        return $this->api('OK');
    }
}