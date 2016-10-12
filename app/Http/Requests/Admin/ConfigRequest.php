<?php

namespace App\Http\Requests\Admin;

use App\Http\Requests\Request;

class ConfigRequest extends Request
{
    public function rules()
    {
        return [
            'watermark' => 'required|core_image',
            'auto_empty' => 'required|core_image',
            'logo' => 'ml',
            'logo.*.image' => 'required|core_image',
            'tax_passenger_price' => 'required|integer',
            'tax_truck_price' => 'required|integer',
            'tax_rename_price' => 'required|integer',
            'tax_passport_price' => 'required|integer',
            'tax_number_price' => 'required|integer',
            'tax_currency' => 'required|integer|exists:currencies,id,show_status,1',
        ];
    }
}