<?php

namespace App\Models\Config;

use App\Core\Model;

class ConfigMl extends Model
{
    protected $table = 'config_ml';

    public $timestamps = false;

    protected $fillable = [
        'lng_id',
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
        return Config::IMAGES_PATH;
    }
}