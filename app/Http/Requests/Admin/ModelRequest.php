<?php

namespace App\Http\Requests\Admin;

use App\Http\Requests\Request;

class ModelRequest extends Request
{
    public function rules()
    {
        $markId = $this->get('mark_id');

        return [
            'mark_id' => 'required|integer|exists:marks,id',
            'category_id' => 'integer|exists:model_categories,id,mark_id,'.$markId,
            'name' => 'required|max:255',
        ];
    }
}