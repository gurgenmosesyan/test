<?php

namespace App\Http\Requests\Admin;

use App\Http\Requests\Request;

class DoorRequest extends Request
{
    public function rules()
    {
        return [
            'name' => 'required|integer',
        ];
    }
}