<?php

namespace App\Http\Requests\User;

use App\Http\Requests\Request;

class ForgotRequest extends Request
{
    public function rules()
    {
        return [
            'email' => 'required|email|exists:users,email'
        ];
    }
}