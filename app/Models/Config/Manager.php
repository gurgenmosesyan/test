<?php

namespace App\Models\Config;

use App\Core\Image\SaveImage;
use App\Core\Language\Language;
use Cache;
use DB;

class Manager
{
    public static function getLogo()
    {
        $cacheKey = 'logo_'.cLng('id');
        $data = Cache::get($cacheKey);
        if ($data == null) {
            $data = Config::joinMl()->where('config.key', Config::KEY_LOGO)->first();
            $data = '/images/config/'.$data->value;
            Cache::forever($cacheKey, $data);
        }
        return $data;
    }

    public static function getAutoEmpty()
    {
        $cacheKey = 'auto_empty';
        $data = Cache::get($cacheKey);
        if ($data == null) {
            $data = Config::where('key', Config::KEY_AUTO_EMPTY)->first();
            Cache::forever($cacheKey, $data);
        }
        return $data;
    }

    public static function getTaxData()
    {
        $cacheKey = 'tax_customs';
        $data = Cache::get($cacheKey);
        if ($data == null) {
            $data = Config::where('key', Config::KEY_TAX_PASSENGER_PRICE)
                        ->orWhere('key', Config::KEY_TAX_TRUCK_PRICE)
                        ->orWhere('key', Config::KEY_TAX_RENAME_PRICE)
                        ->orWhere('key', Config::KEY_TAX_PASSPORT_PRICE)
                        ->orWhere('key', Config::KEY_TAX_NUMBER_PRICE)
                        ->orWhere('key', Config::KEY_TAX_CURRENCY)
                        ->get()->keyBy('key');
            Cache::forever($cacheKey, $data);
        }
        return $data;
    }

    public static function getPaymentPrices()
    {
        $cacheKey = 'payment_prices';
        $data = Cache::get($cacheKey);
        if ($data == null) {
            $data = Config::where('key', Config::KEY_PRICE_TOP_PER_DAY)
                ->orWhere('key', Config::KEY_PRICE_URGENT_PER_DAY)
                ->get()->keyBy('key');
            Cache::forever($cacheKey, $data);
        }
        return $data;
    }

    public static function getPriceAdPerDay()
    {
        $cacheKey = 'price_ad_per_day';
        $data = Cache::get($cacheKey);
        if ($data == null) {
            $data = Config::where('key', Config::KEY_PRICE_AD_PER_DAY)->first();
            Cache::forever($cacheKey, $data);
        }
        return $data;
    }

    public function update($data)
    {
        $configs = Config::all();
        DB::transaction(function() use($configs, $data) {
            $logo = $watermark = $autoEmpty = $taxPassengerPrice = $taxTruckPrice = $taxCurrency = null;
            $taxRenamePrice = $taxPassportPrice = $taxNumberPrice = null;
            $priceTopPerDay = $priceUrgentPerDay = $priceAdPerDay = null;
            foreach ($configs as $config) {
                if ($config->key == Config::KEY_LOGO) {
                    $logo = $config;
                } else if ($config->key == Config::KEY_WATERMARK) {
                    $watermark = $config;
                } else if ($config->key == Config::KEY_AUTO_EMPTY) {
                    $autoEmpty = $config;
                } else if ($config->key == Config::KEY_TAX_PASSENGER_PRICE) {
                    $taxPassengerPrice = $config;
                } else if ($config->key == Config::KEY_TAX_TRUCK_PRICE) {
                    $taxTruckPrice = $config;
                } else if ($config->key == Config::KEY_TAX_RENAME_PRICE) {
                    $taxRenamePrice = $config;
                } else if ($config->key == Config::KEY_TAX_PASSPORT_PRICE) {
                    $taxPassportPrice = $config;
                } else if ($config->key == Config::KEY_TAX_NUMBER_PRICE) {
                    $taxNumberPrice = $config;
                } else if ($config->key == Config::KEY_TAX_CURRENCY) {
                    $taxCurrency = $config;
                } else if ($config->key == Config::KEY_PRICE_TOP_PER_DAY) {
                    $priceTopPerDay = $config;
                } else if ($config->key == Config::KEY_PRICE_URGENT_PER_DAY) {
                    $priceUrgentPerDay = $config;
                } else if ($config->key == Config::KEY_PRICE_AD_PER_DAY) {
                    $priceAdPerDay = $config;
                }
            }
            $this->updateLogo($data['logo'], $logo);
            $this->updateWatermark($data['watermark'], $watermark);
            $this->updateAutoEmpty($data['auto_empty'], $autoEmpty);
            $this->updateTaxPassengerPrice($data['tax_passenger_price'], $taxPassengerPrice);
            $this->updateTaxTruckPrice($data['tax_truck_price'], $taxTruckPrice);
            $this->updateTaxRenamePrice($data['tax_rename_price'], $taxRenamePrice);
            $this->updateTaxPassportPrice($data['tax_passport_price'], $taxPassportPrice);
            $this->updateTaxNumberPrice($data['tax_number_price'], $taxNumberPrice);
            $this->updateTaxCurrency($data['tax_currency'], $taxCurrency);
            $this->updatePriceTopPerDay($data['price_top_per_day'], $priceTopPerDay);
            $this->updatePriceUrgentPerDay($data['price_urgent_per_day'], $priceUrgentPerDay);
            $this->updatePriceAdPerDay($data['price_ad_per_day'], $priceAdPerDay);
            $this->removeCache();
        });
    }

    protected function updateLogo($data, $logo)
    {
        if ($logo == null) {
            $logo = new Config();
            $logo->key = Config::KEY_LOGO;
            $logo->value = '';
            $logo->save();
        }
        $mlsData = $logo->ml->keyBy('lng_id');

        $mls = [];
        $i = 0;
        foreach ($data as $lngId => $value) {
            $mls[$i] = new ConfigMl(['lng_id' => $lngId]);
            if (isset($mlsData[$lngId])) {
                SaveImage::save($value['image'], $mlsData[$lngId], 'value');
                $mls[$i]->value = $mlsData[$lngId]->value;
            } else {
                SaveImage::save($value['image'], $mls[$i], 'value');
            }
            $i++;
        }
        $logo->ml()->delete();
        $logo->ml()->saveMany($mls);
    }

    protected function updateWatermark($data, $watermark)
    {
        if ($watermark == null) {
            $watermark = new Config();
            $watermark->key = Config::KEY_WATERMARK;
        }
        SaveImage::save($data, $watermark, 'value');
        $watermark->save();
    }

    protected function updateAutoEmpty($data, $autoEmpty)
    {
        if ($autoEmpty == null) {
            $autoEmpty = new Config();
            $autoEmpty->key = Config::KEY_AUTO_EMPTY;
        }
        SaveImage::save($data, $autoEmpty, 'value');
        $autoEmpty->save();
    }

    protected function updateTaxPassengerPrice($data, $taxPassengerPrice)
    {
        if ($taxPassengerPrice == null) {
            $taxPassengerPrice = new Config();
            $taxPassengerPrice->key = Config::KEY_TAX_PASSENGER_PRICE;
        }
        $taxPassengerPrice->value = $data;
        $taxPassengerPrice->save();
    }

    protected function updateTaxTruckPrice($data, $taxTruckPrice)
    {
        if ($taxTruckPrice == null) {
            $taxTruckPrice = new Config();
            $taxTruckPrice->key = Config::KEY_TAX_TRUCK_PRICE;
        }
        $taxTruckPrice->value = $data;
        $taxTruckPrice->save();
    }

    protected function updateTaxRenamePrice($data, $taxRenamePrice)
    {
        if ($taxRenamePrice == null) {
            $taxRenamePrice = new Config();
            $taxRenamePrice->key = Config::KEY_TAX_RENAME_PRICE;
        }
        $taxRenamePrice->value = $data;
        $taxRenamePrice->save();
    }

    protected function updateTaxPassportPrice($data, $taxPassportPrice)
    {
        if ($taxPassportPrice == null) {
            $taxPassportPrice = new Config();
            $taxPassportPrice->key = Config::KEY_TAX_PASSPORT_PRICE;
        }
        $taxPassportPrice->value = $data;
        $taxPassportPrice->save();
    }

    protected function updateTaxNumberPrice($data, $taxNumberPrice)
    {
        if ($taxNumberPrice == null) {
            $taxNumberPrice = new Config();
            $taxNumberPrice->key = Config::KEY_TAX_NUMBER_PRICE;
        }
        $taxNumberPrice->value = $data;
        $taxNumberPrice->save();
    }

    protected function updateTaxCurrency($data, $taxCurrency)
    {
        if ($taxCurrency == null) {
            $taxCurrency = new Config();
            $taxCurrency->key = Config::KEY_TAX_CURRENCY;
        }
        $taxCurrency->value = $data;
        $taxCurrency->save();
    }

    protected function updatePriceTopPerDay($data, $priceTopPerDay)
    {
        if ($priceTopPerDay == null) {
            $priceTopPerDay = new Config();
            $priceTopPerDay->key = Config::KEY_PRICE_TOP_PER_DAY;
        }
        $priceTopPerDay->value = $data;
        $priceTopPerDay->save();
    }

    protected function updatePriceUrgentPerDay($data, $priceUrgentPerDay)
    {
        if ($priceUrgentPerDay == null) {
            $priceUrgentPerDay = new Config();
            $priceUrgentPerDay->key = Config::KEY_PRICE_URGENT_PER_DAY;
        }
        $priceUrgentPerDay->value = $data;
        $priceUrgentPerDay->save();
    }

    protected function updatePriceAdPerDay($data, $priceAdPerDay)
    {
        if ($priceAdPerDay == null) {
            $priceAdPerDay = new Config();
            $priceAdPerDay->key = Config::KEY_PRICE_AD_PER_DAY;
        }
        $priceAdPerDay->value = $data;
        $priceAdPerDay->save();
    }

    protected function removeCache()
    {
        Cache::forget('auto_empty');
        Cache::forget('tax_customs');
        Cache::forget('payment_prices');

        $languages = Language::all();
        foreach ($languages as $lng) {
            Cache::forget('logo_'.$lng->id);
        }
    }
}