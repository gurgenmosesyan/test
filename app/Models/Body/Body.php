<?php

namespace App\Models\Body;

use App\Core\Model;

class Body extends Model
{
    const IMAGES_PATH = 'images/body';

    const SHOW_IN_SEARCH = '1';
    const NOT_SHOW_IN_SEARCH = '0';

    protected $table = 'bodies';

    protected $fillable = [
        'show_in_search',
        'sort_order',
        'show_status'
    ];

    public function getImage()
    {
        return url('/'.self::IMAGES_PATH.'/'.$this->image);
    }

    public function scopeInSearch($query)
    {
        return $query->where('show_in_search', self::SHOW_IN_SEARCH);
    }

    public function ml()
    {
        return $this->hasMany(BodyMl::class, 'id', 'id')->active();
    }

    public function current()
    {
        return $this->hasOne(BodyMl::class, 'id', 'id')->where('lng_id', cLng('id'))->active();
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