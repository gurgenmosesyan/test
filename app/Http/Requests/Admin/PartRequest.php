<?php

namespace App\Http\Requests\Admin;

use App\Http\Requests\Request;

class PartRequest extends Request
{
    public function rules()
    {
        $markId = $this->get('mark_id');

        return [
            'mark_id' => 'required|integer|exists:marks,id,show_status,1',
            'model_id' => 'required|integer|exists:models,id,mark_id,'.$markId.',show_status,1',
            'currency_id' => 'required|integer|exists:currencies,id,show_status,1',
            'part1_price' => 'required|integer',
            'part1_service_price' => 'required|integer',
            'part2_price' => 'required|integer',
            'part2_service_price' => 'required|integer',
            'part3_price' => 'required|integer',
            'part3_service_price' => 'required|integer',
            'part4_price' => 'required|integer',
            'part4_service_price' => 'required|integer',
            'part5_price' => 'required|integer',
            'part5_service_price' => 'required|integer',
            'part6_price' => 'required|integer',
            'part6_service_price' => 'required|integer',
            'part7_price' => 'required|integer',
            'part7_service_price' => 'required|integer',
            'part8_price' => 'required|integer',
            'part8_service_price' => 'required|integer',
            'part9_price' => 'required|integer',
            'part9_service_price' => 'required|integer',
            'part10_price' => 'required|integer',
            'part10_service_price' => 'required|integer'
        ];
    }
}