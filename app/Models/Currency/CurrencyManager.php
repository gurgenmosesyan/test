<?php

namespace App\Models\Currency;

use App\Core\Image\SaveImage;
use Cache;
use DB;

class CurrencyManager
{
    protected static $currencies = null;
    protected static $defaultCurrency = null;
    protected static $currentCurrency = null;

    public function all()
    {
        if (self::$currencies === null) {
            $cacheKey = 'currencies';
            self::$currencies = Cache::get($cacheKey);
            if (self::$currencies == null) {
                self::$currencies = Currency::active()->ordered()->get()->keyBy('id');
                Cache::forever($cacheKey, self::$currencies);
            }
        }
        return self::$currencies;
    }

    public function defaultCurrency()
    {
        if (self::$defaultCurrency === null) {
            foreach ($this->all() as $currency) {
                if ($currency->isDefault()) {
                    self::$defaultCurrency = $currency;
                    break;
                }
            }
        }
        return self::$defaultCurrency;
    }

    public function currentCurrency()
    {
        $currencies = $this->all();
        if (isset($_COOKIE['currency']) && isset($currencies[$_COOKIE['currency']])) {
            return $currencies[$_COOKIE['currency']];
        } else {
            return $this->defaultCurrency();
        }
    }

    public function store($data)
    {
        $data = $this->processSave($data);
        $currency = new Currency($data);
        SaveImage::save($data['icon'], $currency, 'icon');
        $currency->show_status = Currency::STATUS_ACTIVE;
        DB::transaction(function() use($currency) {
            $currency->save();
            $this->updateDefault($currency);
            $this->removeCache();
        });
        return true;
    }

    public function update($id, $data)
    {
        $currency = Currency::active()->findOrFail($id);
        SaveImage::save($data['icon'], $currency, 'icon');
        $data = $this->processSave($data);
        DB::transaction(function() use($currency, $data) {
            $currency->update($data);
            $this->updateDefault($currency);
            $this->removeCache();
        });
        return true;
    }

    protected function processSave($data)
    {
        if (!isset($data['default'])) {
            $data['default'] = Currency::IS_NOT_DEFAULT;
        }
        return $data;
    }

    protected function updateDefault(Currency $currency)
    {
        if ($currency->default == Currency::IS_DEFAULT) {
            Currency::active()->where('id', '!=', $currency->id)->update(['default' => Currency::IS_NOT_DEFAULT]);
        } else {
            Currency::active()->where('code', 'usd')->update(['default' => Currency::IS_DEFAULT]);
        }
    }

    public function delete($id)
    {
        Currency::where('id', $id)->update(['show_status' => Currency::STATUS_DELETED]);
        return true;
    }

    protected function removeCache()
    {
        Cache::forget('currencies');
    }
}