<?php

namespace App\Models\Transmission;

use App\Core\Model;

class TransmissionMl extends Model
{
    protected $table = 'transmissions_ml';

    public $timestamps = false;

    protected $fillable = [
        'lng_id',
        'name'
    ];
}