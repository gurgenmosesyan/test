<?php

namespace App\Models\User;

use App\Core\Model;
use Illuminate\Auth\Authenticatable;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;

class User extends Model implements AuthenticatableContract
{
    use Authenticatable;

    protected $guard = 'user';

    protected $table = 'users';

    protected $fillable = [
        'email',
        'first_name',
        'last_name',
    ];

    protected $hidden = [
        'password',
        'remember_token',
        'created_at',
        'updated_at'
    ];
}