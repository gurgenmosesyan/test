<?php

namespace App\Models\InteriorColor;

use App\Core\Model;

class ColorMl extends Model
{
    protected $table = 'interior_colors_ml';

    public $timestamps = false;

    protected $fillable = [
        'lng_id',
        'name'
    ];
}