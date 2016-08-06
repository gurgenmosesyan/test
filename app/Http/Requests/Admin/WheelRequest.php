<?php

namespace App\Http\Requests\Admin;

use App\Http\Requests\Request;

class WheelRequest extends Request
{
    public function rules()
    {
        return [
            'count' => 'required|integer',
        ];
    }
}