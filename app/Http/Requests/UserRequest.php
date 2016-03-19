<?php

namespace App\Http\Requests;

class UserRequest extends Request
{
    public function rules()
    {
        return [
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6|max:255|regex:/[a-z]{1,}[0-9]{1,}/i',
            're_password' => 'required|same:password',
            'first_name' => 'required|max:255',
            'last_name' => 'required|max:255',
            'phone' => 'required|max:30'
        ];
    }
}