<?php

namespace App\Models\Mark;

use App\Models\Model;

class Mark extends Model
{
    protected $table = 'mark';

    public function ml()
    {
        return $this->hasMany(MarkMl::class, 'id', 'id');
    }

    public function current()
    {
        //return $this->ml()->where('lng_id', )
    }
}