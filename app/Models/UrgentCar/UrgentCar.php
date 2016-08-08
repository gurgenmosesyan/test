<?php

namespace App\Models\UrgentCar;

use App\Core\Model;
use App\Models\Auto\Auto;

class UrgentCar extends Model
{
    protected $table = 'urgent_cars';

    protected $fillable = [
        'auto_id',
        'user_id',
        'deadline',
        'show_status'
    ];

    public function auto()
    {
        return $this->belongsTo(Auto::class, 'auto_id', 'id')->active();
    }
}