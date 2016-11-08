<?php

namespace App\Http\Requests\Admin;

use App\Http\Requests\Request;
use Route;

class UrgentCarRequest extends Request
{
    public function rules()
    {
        $params = Route::getCurrentRoute()->parameters();
        $urgentCarId = '';
        if (isset($params['id'])) {
            $urgentCarId = ','.$params['id'];
        }
        return [
            'auto_id' => 'required|integer|exists:autos,id,show_status,1|unique:urgent_cars,auto_id'.$urgentCarId.',NULL,id,show_status,1',
            'user_id' => 'integer|exists,users,id,show_status,1',
            'deadline' => 'required|date'
        ];
    }
}