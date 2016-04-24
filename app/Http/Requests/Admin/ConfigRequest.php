<?php

namespace App\Http\Requests\Admin;

use App\Http\Requests\Request;

class ConfigRequest extends Request
{
    public function rules()
    {
        return [
            'watermark' => 'required|core_image'
        ];
    }
}