<?php

namespace App\Models\Option;

use App\Models\Model;

class Option extends Model
{
    protected $table = 'options';

    protected $fillable = [
        'show_status'
    ];

    public function ml()
    {
        return $this->hasMany(OptionMl::class, 'id', 'id')->active();
    }

    public function current()
    {
        return $this->hasOne(OptionMl::class, 'id', 'id')->where('lng_id', cLng('id'))->active();
    }
}