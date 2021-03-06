<?php

namespace App\Models\Engine;

use App\Core\Model;

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
        return $this->hasOne(EngineMl::class, 'id', 'id')->where('lng_id', cLng('id'))->active();
    }
}