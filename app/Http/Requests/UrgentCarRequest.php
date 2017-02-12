<?php

namespace App\Http\Requests;

class UrgentCarRequest extends Request
{
    public function rules()
    {
        $dayInStr = '';
        for ($i = 1; $i < 31; $i++) {
            $dayInStr .= $i.',';
        }
        $dayInStr = rtrim($dayInStr, ',');

        return [
            'auto_id' => 'required|integer',
            'day' => 'required|in:'.$dayInStr
        ];
    }
}