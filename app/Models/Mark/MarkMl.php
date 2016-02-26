<?php

namespace App\Models\Mark;

use App\Models\Model;

class MarkMl extends Model
{
    protected $table = 'mark_ml';

    protected $fillable = [
        'lng_id',
        'name'
    ];
}