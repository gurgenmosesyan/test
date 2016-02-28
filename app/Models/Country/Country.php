<?php

namespace App\Models\Country;

use App\Models\Model;

class Country extends Model
{
    protected $table = 'countries';

    protected $fillable = [
        'show_status'
    ];

    public function ml()
    {
        return $this->hasMany(CountryMl::class, 'id', 'id')->active();
    }

    public function current()
    {
        return $this->hasOne(CountryMl::class, 'id', 'id')->where('lng_id', cLng('id'))->active();
    }
}