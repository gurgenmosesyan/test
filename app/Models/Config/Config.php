<?php

namespace App\Models\Config;

use App\Core\Model;

class Config extends Model
{
    const KEY_WATERMARK = 'watermark';
    const KEY_AUTO_EMPTY = 'auto_empty';
    const IMAGES_PATH = 'images/config';

    protected $table = 'config';

    protected $fillable = [
        'value'
    ];

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