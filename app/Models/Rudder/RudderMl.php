<?php

namespace App\Models\Rudder;

use App\Models\Model;

class RudderMl extends Model
{
    protected $table = 'rudders_ml';

    public $timestamps = false;

    protected $fillable = [
        'lng_id',
        'name'
    ];
}