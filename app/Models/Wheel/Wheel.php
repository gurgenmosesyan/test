<?php

namespace App\Models\Wheel;

use App\Core\Model;

class Wheel extends Model
{
    protected $table = 'wheels';

    protected $fillable = [
        'count',
        'show_status'
    ];
}