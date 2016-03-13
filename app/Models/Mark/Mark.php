<?php

namespace App\Models\Mark;

use App\Core\Model;

class Mark extends Model
{
    const IMAGES_PATH = 'images/mark';

    protected $table = 'marks';

    protected $fillable = [
        'name',
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