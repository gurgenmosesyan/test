<?php

namespace App\Models\Language;

use App\Models\Model;

class Language extends Model
{
    const DEFAULT_LNG = '1';
    const NOT_DEFAULT_LNG = '0';

    protected $table = 'languages';

    protected $fillable = [
        'code',
        'name',
        //'icon',
        'default'
    ];

    public function scopeDefaultLng($query)
    {
        return $query->where('default', self::DEFAULT_LNG);
    }
}