<?php

namespace App\Models\Ad;

use App\Core\Model;

class Ad extends Model
{
    const KEY_TOP = 'top';
    const KEY_THIN = 'thin';
    const KEY_RIGHT = 'right';
    const KEY_BOTTOM = 'bottom';
    const STATUS_PENDING = 'pending';
    const STATUS_CONFIRMED = 'confirmed';
    const STATUS_DECLINED = 'declined';
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

    public function scopeLatest($query)
    {
        return $query->orderBy('ads.id', 'desc');
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