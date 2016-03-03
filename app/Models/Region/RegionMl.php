<?php

namespace App\Models\Region;

use App\Core\Model;

class RegionMl extends Model
{
    protected $table = 'regions_ml';

    public $timestamps = false;

    protected $fillable = [
        'lng_id',
        'name'
    ];
}