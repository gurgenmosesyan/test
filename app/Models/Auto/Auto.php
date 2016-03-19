<?php

namespace App\Models\Auto;

use App\Core\Model;

class Auto extends Model
{
    const MILEAGE_MEASUREMENT_KM = 'km';
    const MILEAGE_MEASUREMENT_MILE = 'mile';
    const CONTRACT = '1';
    const NOT_CONTRACT = '0';
    const EXCHANGE = '1';
    const AUCTION = '1';
    const NOT_AUCTION = '0';
    const BANK = '1';
    const NOT_BANK = '0';
    const NOT_EXCHANGE = '0';
    const PARTIAL_PAY = '1';
    const NOT_PARTIAL_PAY = '0';
    const CUSTOM_CLEARED = '1';
    const NOT_CUSTOM_CLEARED = '0';
    const DAMAGED = '1';
    const NOT_DAMAGED = '0';
    const STATUS_PENDING = 'pending';
    const STATUS_APPROVED = 'approved';
    const STATUS_BLOCKED = 'blocked';

    protected $table = 'autos';

    protected $fillable = [
        'user_id',
        'mark_id',
        'model_category_id',
        'model_id',
        'body_id',
        'transmission_id',
        'rudder_id',
        'color_id',
        'interior_color_id',
        'engine_id',
        'cylinder_id',
        'train_id',
        'door_id',
        'wheel_id',
        'country_id',
        'region_id',
        'tuning',
        'year',
        'mileage',
        'mileage_measurement',
        'volume_1',
        'volume_2',
        'horsepower',
        'place',
        'price_amd',
        'price_usd',
        'price_eur',
        'contract',
        'auction',
        'bank',
        'exchange',
        'partial_pay',
        'custom_cleared',
        'damaged',
        'vin',
        'description',
        'additional_phone',
        'term',
        'status'
    ];

    public function options()
    {
        return $this->hasMany(AutoOption::class, 'auto_id', 'id');
    }

    public function images()
    {
        return $this->hasMany(AutoImage::class, 'auto_id', 'id');
    }
}