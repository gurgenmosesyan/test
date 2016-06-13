<?php

namespace App\Core;

use Illuminate\Database\Eloquent\Model as EloquentModel;

class Model extends EloquentModel
{
    const STATUS_ACTIVE = '1';
    const STATUS_INACTIVE = '2';
    const STATUS_DELETED = '0';

    public function scopeJoinMl($query)
    {
        return $query->join($this->table.'_ml as ml', function($query) {
            $query->on('ml.id', '=', $this->table.'.id')->where('ml.lng_id', '=', cLng('id'))->where('ml.show_status', '=', self::STATUS_ACTIVE);
        });
    }

    public function scopeActive($query)
    {
        return $query->where($this->table.'.show_status', self::STATUS_ACTIVE);
    }

    public function scopeCurrent($query)
    {
        return $query->where($this->table.'.lng_id', cLng('id'));
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy($this->table.'.sort_order', 'asc')->orderBy($this->table.'.id', 'desc');
    }
}