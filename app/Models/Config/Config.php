<?php

namespace App\Models\Config;

use App\Core\Model;

class Config extends Model
{
    const KEY_LOGO = 'logo';
    const KEY_WATERMARK = 'watermark';
    const KEY_AUTO_EMPTY = 'auto_empty';
    const IMAGES_PATH = 'images/config';

    protected $table = 'config';

    protected $fillable = [
        'value'
    ];

    public function scopeJoinMl($query)
    {
        return $query->join('config_ml as ml', function($query) {
            $query->on('ml.id', '=', 'config.id')->where('ml.lng_id', '=', cLng('id'));
        });
    }

    public function ml()
    {
        return $this->hasMany(ConfigMl::class, 'id', 'id');
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