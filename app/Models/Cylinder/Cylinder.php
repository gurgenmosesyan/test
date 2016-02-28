<?php

namespace App\Models\Cylinder;

use App\Models\Model;

class Cylinder extends Model
{
    protected $table = 'cylinders';

    protected $fillable = [
        'name',
        'show_status'
    ];
}