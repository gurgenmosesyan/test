<?php

namespace App\Models\Train;

use App\Models\Model;

class Train extends Model
{
    protected $table = 'trains';

    protected $fillable = [
        'show_status'
    ];

    public function ml()
    {
        return $this->hasMany(TrainMl::class, 'id', 'id')->active();
    }

    public function current()
    {
        return $this->ml()->where('lng_id', cLng('id'));
    }
}