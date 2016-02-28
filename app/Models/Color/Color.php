<?php

namespace App\Models\Color;

use App\Models\Model;

class Color extends Model
{
    protected $table = 'colors';

    protected $fillable = [
        'show_status'
    ];

    public function ml()
    {
        return $this->hasMany(ColorMl::class, 'id', 'id')->active();
    }

    public function current()
    {
        return $this->ml()->where('lng_id', cLng('id'));
    }
}