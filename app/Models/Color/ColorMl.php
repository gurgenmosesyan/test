<?php

namespace App\Models\Color;

use App\Core\Model;

class ColorMl extends Model
{
    protected $table = 'colors_ml';

    public $timestamps = false;

    protected $fillable = [
        'lng_id',
        'name'
    ];
}