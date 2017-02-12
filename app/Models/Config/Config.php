<?php

namespace App\Models\Config;

use App\Core\Model;

class Config extends Model
{
    const KEY_LOGO = 'logo';
    const KEY_WATERMARK = 'watermark';
    const KEY_AUTO_EMPTY = 'auto_empty';
    const KEY_TAX_PASSENGER_PRICE = 'tax_passenger_price';
    const KEY_TAX_TRUCK_PRICE = 'tax_truck_price';
    const KEY_TAX_RENAME_PRICE = 'tax_rename_price';
    const KEY_TAX_PASSPORT_PRICE = 'tax_passport_price';
    const KEY_TAX_NUMBER_PRICE = 'tax_number_price';
    const KEY_TAX_CURRENCY = 'tax_currency';
    const KEY_PRICE_TOP_PER_DAY = 'price_top_per_day';
    const KEY_PRICE_URGENT_PER_DAY = 'price_urgent_per_day';
    const KEY_PRICE_AD_PER_DAY = 'price_ad_per_day';

    const IMAGES_PATH = 'images/config';

    protected $table = 'config';

    protected $fillable = [
        'value'
    ];

    public function scopeJoinMl($query)
    {
        return $query->join('config_ml as ml', function($query) {
            $query->on('ml.id', '=', 'config.id')->where('ml.lng_id', '=', cLng('id'));
        });
    }

    public function ml()
    {
        return $this->hasMany(ConfigMl::class, 'id', 'id');
    }

    public function getFile($column)
    {
        return $this->$column;
    }

    public function setFile($file, $column)
    {
        $this->attributes[$column] = $file;
    }

    public function getStorePath()
    {
        return self::IMAGES_PATH;
    }
}