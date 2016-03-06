<?php

namespace App\Models\Option;

use App\Core\Model;

class Option extends Model
{
    protected $table = 'options';

    protected $fillable = [
        'show_status'
    ];

    public function scopeJoinMl($query)
    {
        return $query->join('options_ml AS ml', function($query) {
            $query->on('ml.id', '=', 'options.id')->where('ml.lng_id', '=', cLng('id'))->where('ml.show_status', '=', self::STATUS_ACTIVE);
        });
    }

    public function ml()
    {
        return $this->hasMany(OptionMl::class, 'id', 'id')->active();
    }

    public function current()
    {
        return $this->hasOne(OptionMl::class, 'id', 'id')->where('lng_id', cLng('id'))->active();
    }
}