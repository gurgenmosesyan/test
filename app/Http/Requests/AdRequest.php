<?php

namespace App\Http\Requests;

use App\Models\Ad\Ad;

class AdRequest extends Request
{
    public function rules()
    {
        $dayInStr = '';
        for ($i = 1; $i < 31; $i++) {
            $dayInStr .= $i.',';
        }
        $dayInStr = rtrim($dayInStr, ',');

        return [
            'image' => 'required|core_image',
            'key' => 'required|in:'.Ad::KEY_THIN.','.Ad::KEY_RIGHT.','.Ad::KEY_BOTTOM,
            'link' => 'url:max:255',
            'day' => 'required|in:'.$dayInStr
        ];
    }
}