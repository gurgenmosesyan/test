<?php

namespace App\Models\Country;

use App\Models\Model;

class CountryMl extends Model
{
    protected $table = 'countries_ml';

    public $timestamps = false;

    protected $fillable = [
        'lng_id',
        'name'
    ];
}