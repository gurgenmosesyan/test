<?php

namespace App\Models\Model;

use App\Core\Model as CoreModel;

class Model extends CoreModel
{
    protected $table = 'models';

    protected $fillable = [
        'mark_id',
        'category_id',
        'name',
        'show_status'
    ];
}