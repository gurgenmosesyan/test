<?php

namespace App\Http\Requests\Admin;

use App\Http\Requests\Request;

class RegionRequest extends Request
{
    public function rules()
    {
        return [
            'country_id' => 'required|integer|exists:countries,id',
            'ml' => 'ml',
            'ml.*.name' => 'required|max:255'
        ];
    }
}