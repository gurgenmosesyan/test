<?php

namespace App\Models\Body;

use App\Models\Model;

class BodyMl extends Model
{
    protected $table = 'bodies_ml';

    public $timestamps = false;

    protected $fillable = [
        'lng_id',
        'name'
    ];
}