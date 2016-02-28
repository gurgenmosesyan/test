<?php

namespace App\Models\InteriorColor;

use App\Models\Model;

class Color extends Model
{
    protected $table = 'interior_colors';

    protected $fillable = [
        'show_status'
    ];

    public function ml()
    {
        return $this->hasMany(ColorMl::class, 'id', 'id')->active();
    }

    public function current()
    {
        return $this->hasOne(ColorMl::class, 'id', 'id')->where('lng_id', cLng('id'))->active();
    }
}