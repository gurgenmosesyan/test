<?php

namespace App\Models\Auto;

use App\Core\Model;

class Auto extends Model
{
    const MILEAGE_MEASUREMENT_KM = 'km';
    const MILEAGE_MEASUREMENT_MILE = 'mile';

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
        'place'
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