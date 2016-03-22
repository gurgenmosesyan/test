<?php

namespace App\Http\Requests\Admin;

use App\Http\Requests\Request;

class ModelRequest extends Request
{
    public function rules()
    {
        $markId = $this->get('mark_id');

        return [
            'mark_id' => 'required|integer|exists:marks,id,show_status,1',
            'category_id' => 'integer|exists:model_categories,id,mark_id,'.$markId.',show_status,1',
            'name' => 'required|max:255',
        ];
    }
}