<?php

namespace App\Models\User;

use App\Core\Model;

class UserFavorite extends Model
{
    protected $table = 'user_favorites';

    public $timestamps = false;

    protected $fillable = [
        'user_id',
        'auto_id'
    ];
}