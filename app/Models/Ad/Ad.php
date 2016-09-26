<?php

namespace App\Models\Ad;

use App\Core\Model;

class Ad extends Model
{
    const KEY_TOP = 'top';
    const KEY_THIN = 'thin';
    const KEY_RIGHT = 'right';
    const KEY_BOTTOM = 'bottom';

    const IMAGES_PATH = 'images/cucataxtak';

    protected $table = 'ads';

    protected $fillable = [
        'key',
        'user_id',
        'link',
        'deadline',
        'show_status'
    ];

    public function getImage()
    {
        return url(self::IMAGES_PATH.'/'.$this->image);
    }

    public function scopeInDate($query)
    {
        $query->where('deadline', '>=', date('Y-m-d'));
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