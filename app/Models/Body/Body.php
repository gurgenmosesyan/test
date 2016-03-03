<?php

namespace App\Models\Body;

use App\Core\Model;

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
        return $this->hasOne(BodyMl::class, 'id', 'id')->where('lng_id', cLng('id'))->active();
    }
}