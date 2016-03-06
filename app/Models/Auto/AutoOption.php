<?php

namespace App\Models\Auto;

use App\Core\Model;

class AutoOption extends Model
{
    protected $table = 'auto_options';

    public $timestamps = false;

    protected $fillable = [
        'option_id'
    ];
}