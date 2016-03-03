<?php

namespace App\Models\Engine;

use App\Core\Model;

class EngineMl extends Model
{
    protected $table = 'engines_ml';

    public $timestamps = false;

    protected $fillable = [
        'lng_id',
        'name'
    ];
}