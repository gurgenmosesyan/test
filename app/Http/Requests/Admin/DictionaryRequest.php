<?php

namespace App\Http\Requests\Admin;

use App\Http\Requests\Request;
use App\Models\Language\Language;

class DictionaryRequest extends Request
{
    public function rules()
    {
        $languages = Language::all();

        $rules = [
            'key' => 'required',
            'origin_key',
            'app' => 'required|in:1,2',
        ];
        foreach ($languages as $lng) {
            $rules['ml.'.$lng->code] = 'max:255';
        }
        return $rules;
    }
}