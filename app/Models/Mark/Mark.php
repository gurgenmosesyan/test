<?php

namespace App\Models\Mark;

use App\Models\Model;

class Mark extends Model
{
    protected $table = 'marks';

    protected $fillable = [
        'name',
        'show_status'
    ];
}