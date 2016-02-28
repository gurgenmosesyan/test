<?php

namespace App\Models\Option;

use App\Models\Model;

class OptionMl extends Model
{
    protected $table = 'options_ml';

    public $timestamps = false;

    protected $fillable = [
        'lng_id',
        'name'
    ];
}