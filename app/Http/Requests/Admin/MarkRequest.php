<?php

namespace App\Http\Requests\Admin;

use App\Http\Requests\Request;

class MarkRequest extends Request
{
    public function rules()
    {
        return [
            'name' => 'required|max:255',
            'image' => 'core_image'
        ];
    }
}