<?php

namespace App\Models\ModelCategory;

use App\Models\Model;

class Category extends Model
{
    protected $table = 'model_categories';

    protected $fillable = [
        'mark_id',
        'name',
        'show_status'
    ];
}