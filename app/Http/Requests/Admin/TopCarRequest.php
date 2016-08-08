<?php

namespace App\Http\Requests\Admin;

use App\Http\Requests\Request;

class TopCarRequest extends Request
{
    public function rules()
    {
        return [
            'auto_id' => 'required|integer|exists:autos,id,show_status,1',
            'user_id' => 'integer|exists,users,id,show_status,1',
            'deadline' => 'required|date'
        ];
    }
}