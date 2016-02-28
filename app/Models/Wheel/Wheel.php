<?php

namespace App\Models\Wheel;

use App\Models\Model;

class Wheel extends Model
{
    protected $table = 'wheels';

    protected $fillable = [
        'name',
        'show_status'
    ];
}