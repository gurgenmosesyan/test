<?php

namespace App\Http\Requests\Admin;

use App\Http\Requests\Request;
use App\Models\Auto\Auto;

class AutoRequest extends Request
{
    public function rules()
    {
        $markId = $this->get('mark_id');
        $countryId = $this->get('country_id');

        return [
            'mark_id' => 'required|integer|exists:marks,id',
            'model_id' => 'required|integer|exists:models,id,mark_id,'.$markId,
            'body_id' => 'required|integer|exists:bodies,id',
            'transmission_id' => 'required|integer|exists:transmissions,id',
            'rudder_id' => 'required|integer|exists:rudders,id',
            'color_id' => 'required|integer|exists:colors,id',
            'interior_color_id' => 'integer|exists:interior_colors,id',
            'engine_id' => 'required|integer|exists:engines,id',
            'cylinder_id' => 'integer|exists:cylinders,id',
            'train_id' => 'integer|exists:trains,id',
            'door_id' => 'integer|exists:doors,id',
            'wheel_id' => 'integer|exists:wheels,id',
            'country_id' => 'required|integer|exists:countries,id',
            'region_id' => 'integer|exists:regions,id,country_id,'.$countryId,
            'tuning' => 'max:255',
            'year' => 'required|integer',
            'mileage' => 'required|integer',
            'mileage_measurement' => 'required|in:'.Auto::MILEAGE_MEASUREMENT_KM.','.Auto::MILEAGE_MEASUREMENT_MILE,
            'volume_1' => 'required_with:volume_2|integer|max:15',
            'volume_2' => 'required_with:volume_1|integer|max:15',
            'horsepower' => 'integer|max:9999',
            'place' => 'max:255',
            'price_amd' => 'integer',
            'price_usd' => 'integer',
            'price_eur' => 'integer',
            'contract' => 'in:'.Auto::CONTRACT.','.Auto::NOT_CONTRACT,
            'auction' => 'in:'.Auto::AUCTION.','.Auto::NOT_AUCTION,
            'bank' => 'in:'.Auto::BANK.','.Auto::NOT_BANK,
            'exchange' => 'in:'.Auto::EXCHANGE.','.Auto::NOT_EXCHANGE,
            'partial_pay' => 'in:'.Auto::PARTIAL_PAY.','.Auto::NOT_PARTIAL_PAY,
            'custom_cleared' => 'in:'.Auto::CUSTOM_CLEARED.','.Auto::NOT_CUSTOM_CLEARED,
            'damaged' => 'in:'.Auto::DAMAGED.','.Auto::NOT_DAMAGED,
            'vin' => 'max:255',
            'description' => 'max:50000',
            //'additional_phone' => 'max:255',
            'term' => 'required_if:save_mode,add|integer|between:1,10',
            'options.*' => 'required|integer|exists:options,id',
            'images' => 'array|max:10',
            'images.*.id' => 'integer',
            'images.*.image' => 'required|core_image',
            'images.*.rotate' => 'numeric'
        ];
    }
}