<?php

namespace App\Models\Tax;

use App\Core\Model;

class Tax extends Model
{
    protected $table = 'tax';

    protected $fillable = [
        'mark_id',
        'model_id',
        'year',
        'engine_id',
        'volume',
        'currency_id',
        'price'
    ];
}