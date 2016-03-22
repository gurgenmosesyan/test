<?php

namespace App\Http\Requests\User;

use App\Http\Requests\Request;
use App\Models\User\User;

class ForgotRequest extends Request
{
    public function rules()
    {
        return [
            'email' => 'required|email|exists:users,email,show_status,1,status,!'.User::STATUS_REGISTERED
        ];
    }
}