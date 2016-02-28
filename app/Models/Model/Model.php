<?php

namespace App\Models\Model;

use App\Models\Model as LaravelModel;

class Model extends LaravelModel
{
    protected $table = 'models';

    protected $fillable = [
        'mark_id',
        'category_id',
        'name',
        'show_status'
    ];
}