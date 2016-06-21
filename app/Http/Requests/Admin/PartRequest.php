<?php

namespace App\Http\Requests\Admin;

use App\Http\Requests\Request;
use Route;

class PartRequest extends Request
{
    public function rules()
    {
        $markId = $this->get('mark_id');
        $modelId = $this->get('model_id');

        $params = Route::getCurrentRoute()->parameters();
        $partId = 'NULL';
        if (isset($params['id'])) {
            $partId = $params['id'];
        }

        return [
            'mark_id' => 'required|integer|exists:marks,id,show_status,1|unique:parts,mark_id,'.$partId.',id,model_id,'.$modelId,
            'model_id' => 'required|integer|exists:models,id,mark_id,'.$markId.',show_status,1|unique:parts,model_id,'.$partId.',id,mark_id,'.$markId,
            'currency_id' => 'required|integer|exists:currencies,id,show_status,1',
            'part1_price' => 'required_with:part1_service_price|integer',
            'part1_service_price' => 'integer',
            'part2_price' => 'required_with:part2_service_price|integer',
            'part2_service_price' => 'integer',
            'part3_price' => 'required_with:part3_service_price|integer',
            'part3_service_price' => 'integer',
            'part4_price' => 'required_with:part4_service_price|integer',
            'part4_service_price' => 'integer',
            'part5_price' => 'required_with:part5_service_price|integer',
            'part5_service_price' => 'integer',
            'part6_price' => 'required_with:part6_service_price|integer',
            'part6_service_price' => 'integer',
            'part7_price' => 'required_with:part7_service_price|integer',
            'part7_service_price' => 'integer',
            'part8_price' => 'required_with:part8_service_price|integer',
            'part8_service_price' => 'integer',
            'part9_price' => 'required_with:part9_service_price|integer',
            'part9_service_price' => 'integer',
            'part10_price' => 'required_with:part10_service_price|integer',
            'part10_service_price' => 'integer'
        ];
    }
}