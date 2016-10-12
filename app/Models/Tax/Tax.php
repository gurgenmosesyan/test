<?php

namespace App\Models\Tax;

use App\Core\Model;

class Tax extends Model
{
    const BODY_PASSENGER = 'passenger';
    const BODY_TRUCK = 'truck';

    protected $table = 'tax';

    protected $fillable = [
        'mark_id',
        'model_id',
        'year',
        'engine_id',
        'volume',
        'body',
        'price',
        'currency_id',
    ];
}