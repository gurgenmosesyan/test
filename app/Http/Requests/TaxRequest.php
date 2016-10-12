<?php

namespace App\Http\Requests;

class TaxRequest extends Request
{
    public function rules()
    {
        return [
            'mark_id' => 'required|integer',
            'model_id' => 'required|integer',
            'year' => 'required|integer',
            'engine_id' => 'required|integer',
            'volume' => 'required|numeric|max:10'
        ];
    }
}