<?php

namespace App\Http\Requests\User;

use App\Http\Requests\Request;
use App\Models\User\User;

class LoginRequest extends Request
{
    public function rules()
    {
        return [
            'email' => 'required|email',
            'password' => 'required',
            'remember_me' => 'in:'.User::REMEMBER_ME
        ];
    }
}