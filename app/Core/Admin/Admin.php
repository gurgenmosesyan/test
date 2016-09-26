<?php

namespace App\Core\Admin;

use App\Core\Model;
use Illuminate\Auth\Authenticatable;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;

class Admin extends Model implements AuthenticatableContract
{
    const SUPER_ADMIN = '1';
    const NOT_SUPER_ADMIN = '0';

    use Authenticatable;

    protected $guard = 'admin';

    protected $table = 'adm_users';

    protected $fillable = [
        'email',
        'lng_id',
        'homepage',
        'permissions'
    ];

    protected $hidden = [
        'password',
        'permissions',
        'super_admin',
        'remember_token'
    ];

    public function getPermissionsAttribute($value)
    {
        return json_decode($value, true);
    }

    public function isSuperAdmin()
    {
        return $this->super_admin == self::SUPER_ADMIN;
    }
}