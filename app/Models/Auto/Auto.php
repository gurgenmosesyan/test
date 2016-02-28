<?php

namespace App\Models\Auto;

use App\Models\Model;

class Auto extends Model
{
    const MILEAGE_MEASUREMENT_KM = 'km';
    const MILEAGE_MEASUREMENT_MILE = 'mile';

    protected $table = 'autos';

    protected $fillable = [
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
}