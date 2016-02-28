<?php

namespace App\Models\Transmission;

use App\Models\Model;

class Transmission extends Model
{
    protected $table = 'transmissions';

    protected $fillable = [
        'show_status'
    ];

    public function ml()
    {
        return $this->hasMany(TransmissionMl::class, 'id', 'id')->active();
    }

    public function current()
    {
        return $this->hasOne(TransmissionMl::class, 'id', 'id')->where('lng_id', cLng('id'))->active();
    }
}