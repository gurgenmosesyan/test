<?php

namespace App\Models\Rudder;

use App\Models\Model;

class Rudder extends Model
{
    protected $table = 'rudders';

    protected $fillable = [
        'show_status'
    ];

    public function ml()
    {
        return $this->hasMany(RudderMl::class, 'id', 'id')->active();
    }

    public function current()
    {
        return $this->ml()->where('lng_id', cLng('id'));
    }
}