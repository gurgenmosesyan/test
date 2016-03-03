<?php

namespace App\Models\Region;

use App\Core\Model;

class Region extends Model
{
    protected $table = 'regions';

    protected $fillable = [
        'country_id',
        //'show_status'
    ];

    public function ml()
    {
        return $this->hasMany(RegionMl::class, 'id', 'id')->active();
    }

    public function current()
    {
        return $this->hasOne(RegionMl::class, 'id', 'id')->where('lng_id', cLng('id'))->active();
    }
}