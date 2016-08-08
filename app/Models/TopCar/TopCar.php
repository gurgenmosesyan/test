<?php

namespace App\Models\TopCar;

use App\Core\Model;
use App\Models\Auto\Auto;

class TopCar extends Model
{
    protected $table = 'top_cars';

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