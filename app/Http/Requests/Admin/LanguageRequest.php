<?php

namespace App\Http\Requests\Admin;

use App\Http\Requests\Request;
use App\Models\Language\Language;

class LanguageRequest extends Request
{
    public function rules()
    {
        return [
            'code' => 'required|max:30',
            'name' => 'required',
            'default' => 'in:'.Language::DEFAULT_LNG.','.Language::NOT_DEFAULT_LNG
        ];
    }
}