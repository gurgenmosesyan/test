<?php

namespace App\Models\Body;

use App\Models\Model;

class Body extends Model
{
    protected $table = 'bodies';

    protected $fillable = [
        'show_status'
    ];

    public function ml()
    {
        return $this->hasMany(BodyMl::class, 'id', 'id')->active();
    }

    public function current()
    {
        return $this->ml()->where('lng_id', cLng('id'));
    }
}