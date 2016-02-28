<?php

namespace App\Models\Door;

use App\Models\Model;

class Door extends Model
{
    protected $table = 'doors';

    protected $fillable = [
        'name',
        'show_status'
    ];
}