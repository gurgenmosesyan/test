<?php

namespace App\Http\Requests\Admin;

use App\Http\Requests\Request;
use Route;

class TopCarRequest extends Request
{
    public function rules()
    {
        $params = Route::getCurrentRoute()->parameters();
        $topCarId = '';
        if (isset($params['id'])) {
            $topCarId = ','.$params['id'];
        }

        return [
            'auto_id' => 'required|integer|exists:autos,id,show_status,1|unique:top_cars,auto_id'.$topCarId.',NULL,id,show_status,1',
            'user_id' => 'integer|exists,users,id,show_status,1',
            'deadline' => 'required|date'
        ];
    }
}