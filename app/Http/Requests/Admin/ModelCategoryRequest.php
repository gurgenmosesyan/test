<?php

namespace App\Http\Requests\Admin;

use App\Http\Requests\Request;

class ModelCategoryRequest extends Request
{
    public function rules()
    {
        return [
            'mark_id' => 'required|integer|exists:marks,id,show_status,1',
            'name' => 'required|max:255',
        ];
    }
}