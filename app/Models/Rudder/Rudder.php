<?php

namespace App\Models\Rudder;

use App\Core\Model;

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
        return $this->hasOne(RudderMl::class, 'id', 'id')->where('lng_id', cLng('id'))->active();
    }
}