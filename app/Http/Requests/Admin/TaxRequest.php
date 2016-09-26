<?php

namespace App\Http\Requests\Admin;

use App\Http\Requests\Request;

class TaxRequest extends Request
{
    public function rules()
    {
        $markId = $this->get('mark_id');

        return [
            'mark_id' => 'required|integer|exists:marks,id,show_status,1',
            'model_id' => 'required|integer|exists:models,id,mark_id,'.$markId.',show_status,1',
            'year' => 'required|integer',
            'engine_id' => 'required|integer|exists:engines,id,show_status,1',
            'volume' => 'numeric|max:10',
            'currency_id' => 'required|integer|exists:currencies,id,show_status,1',
            'price' => 'required|integer'
        ];
    }
}