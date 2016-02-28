<?php

namespace App\Http\Requests\Admin;

use App\Http\Requests\Request;

class EngineRequest extends Request
{
    public function rules()
    {
        return [
            'ml' => 'ml',
            'ml.*.name' => 'required|max:255'
        ];
    }
}