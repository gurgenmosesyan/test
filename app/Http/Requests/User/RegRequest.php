<?php

namespace App\Http\Requests\User;

use App\Http\Requests\Request;
use App\Models\User\UserManager;

class RegRequest extends Request
{
    public function rules()
    {
        $userManager = new UserManager();
        $userManager->resetAfterDay();

        return [
            'email' => 'required|email|unique:users,email,NULL,id,show_status,1',
            'password' => 'required|min:6|max:255|regex:/[a-z]{1,}[0-9]{1,}/i',
            're_password' => 'required|same:password',
            'first_name' => 'required|max:255',
            'last_name' => 'required|max:255',
            'phone' => 'required|max:30'
        ];
    }
}