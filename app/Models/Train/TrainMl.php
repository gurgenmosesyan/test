<?php

namespace App\Models\Train;

use App\Core\Model;

class TrainMl extends Model
{
    protected $table = 'trains_ml';

    public $timestamps = false;

    protected $fillable = [
        'lng_id',
        'name'
    ];
}