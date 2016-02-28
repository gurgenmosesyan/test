<?php

namespace App\Models\Engine;

use App\Models\Model;

class Engine extends Model
{
    protected $table = 'engines';

    protected $fillable = [
        'show_status'
    ];

    public function ml()
    {
        return $this->hasMany(EngineMl::class, 'id', 'id')->active();
    }

    public function current()
    {
        return $this->ml()->where('lng_id', cLng('id'));
    }
}