<?php

namespace App\Http\Requests\Core;

use App\Http\Requests\Request;
use Auth;

class ProfileRequest extends Request
{
    public function rules()
    {
        $admin = Auth::guard('admin')->user();

        return [
            'email' => 'required|email|unique:adm_users,email,'.$admin->id,
            'password' => 'required_with:re_password|min:6|max:255|regex:/[a-z]{1,}[0-9]{1,}/i',
            're_password' => 'required_with:password|same:password',
            'lng_id' => 'required|integer|exists:languages,id'
        ];
    }
}
