<?php

namespace App\Models\Part;

use App\Core\Model;

class Part extends Model
{
    protected $table = 'parts';

    protected $fillable = [
        'mark_id',
        'model_id',
        'currency_id',
        'part1_price',
        'part1_service_price',
        'part2_price',
        'part2_service_price',
        'part3_price',
        'part3_service_price',
        'part4_price',
        'part4_service_price',
        'part5_price',
        'part5_service_price',
        'part6_price',
        'part6_service_price',
        'part7_price',
        'part7_service_price',
        'part8_price',
        'part8_service_price',
        'part9_price',
        'part9_service_price',
        'part10_price',
        'part10_service_price'
    ];
}