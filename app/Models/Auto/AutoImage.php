<?php

namespace App\Models\Auto;

use App\Core\Model;

class AutoImage extends Model
{
    const IMAGES_PATH = 'images/auto';

    protected $table = 'auto_images';

    public $timestamps = false;

    protected $fillable = [
        'show_status'
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