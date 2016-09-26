<?php

namespace App\Http\Requests\Admin;

use App\Http\Requests\Request;
use App\Models\Ad\Ad;

class AdRequest extends Request
{
    public function rules()
    {
        return [
            'key' => 'required|in:'.Ad::KEY_TOP.','.Ad::KEY_THIN.','.Ad::KEY_RIGHT.','.Ad::KEY_BOTTOM,
            'user_id' => 'integer|exists,users,id,show_status,1',
            'image' => 'required|core_image',
            'link' => 'url|max:255',
            'deadline' => 'required|date'
        ];
    }
}