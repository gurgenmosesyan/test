<?php

namespace App\Models\User;

use App\Core\Model;
use Illuminate\Auth\Authenticatable;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;

class User extends Model implements AuthenticatableContract
{
    const STATUS_REGISTERED = 'registered';
    const STATUS_CONFIRMED = 'confirmed';
    const STATUS_BLOCKED = 'blocked';
    const REMEMBER_ME = '1';
    const SOCIAL_FB = 'fb';
    const SOCIAL_GP = 'gp';

    use Authenticatable;

    protected $guard = 'user';

    protected $table = 'users';

    protected $fillable = [
        'email',
        'password',
        'first_name',
        'last_name',
        'phone',
        'social_id'
    ];

    protected $hidden = [
        'password',
        'hash',
        'remember_token',
        'created_at',
        'updated_at'
    ];
}