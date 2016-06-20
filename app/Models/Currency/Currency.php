<?php

namespace App\Models\Currency;

use App\Core\Model;

class Currency extends Model
{
    const IS_DEFAULT = '1';
    const IS_NOT_DEFAULT = '0';
    const IMAGES_PATH = 'images/currency';

    protected $table = 'currencies';

    protected $fillable = [
        'code',
        'default',
        'rate',
        'sign',
        'price_max',
        'price_from',
        'price_to',
        'price_step',
        'sort_order'
    ];

    public function isDefault()
    {
        return $this->default == self::IS_DEFAULT;
    }

    public function getIcon()
    {
        return url('/'.self::IMAGES_PATH.'/'.$this->icon);
    }

    public function scopeDefault($query)
    {
        return $query->where('default', self::IS_DEFAULT);
    }

    public function getFile($column)
    {
        return $this->$column;
    }

    public function setFile($file, $column)
    {
        $this->attributes[$column] = $file;
    }

    public function getStorePath()
    {
        return self::IMAGES_PATH;
    }
}