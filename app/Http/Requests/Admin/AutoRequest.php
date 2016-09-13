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
        $contract = $this->get('contract');
        $auction = $this->get('auction');
        if ($contract == Auto::CONTRACT || $auction == Auto::AUCTION) {
            $priceRule = $currencyRule = '';
        } else {
            $priceRule = $currencyRule = 'required|';
        }

        return [
            'user_id' => 'required|integer|exists:users,id,show_status,1',
            'mark_id' => 'required|integer|exists:marks,id,show_status,1',
            'model_id' => 'required|integer|exists:models,id,mark_id,'.$markId.',show_status,1',
            'body_id' => 'required|integer|exists:bodies,id,show_status,1',
            'transmission_id' => 'required|integer|exists:transmissions,id,show_status,1',
            'rudder_id' => 'required|integer|exists:rudders,id,show_status,1',
            'color_id' => 'required|integer|exists:colors,id,show_status,1',
            'interior_color_id' => 'integer|exists:interior_colors,id,show_status,1',
            'engine_id' => 'required|integer|exists:engines,id,show_status,1',
            'cylinders' => 'integer|exists:cylinders,count,show_status,1',
            'train_id' => 'integer|exists:trains,id,show_status,1',
            'doors' => 'integer|exists:doors,count,show_status,1',
            'wheels' => 'integer|exists:wheels,count,show_status,1',
            'country_id' => 'required|integer|exists:countries,id,show_status,1',
            'region_id' => 'integer|exists:regions,id,country_id,'.$countryId.',show_status,1',
            'tuning' => 'max:255',
            'year' => 'required|integer',
            'mileage' => 'required|integer',
            'mileage_measurement' => 'required|in:'.Auto::MILEAGE_MEASUREMENT_KM.','.Auto::MILEAGE_MEASUREMENT_MILE,
            'volume' => 'numeric|max:10',
            'horsepower' => 'integer|max:9999',
            'place' => 'max:255',
            'currency_id' => $currencyRule.'integer|exists:currencies,id,show_status,1',
            'price' => $priceRule.'integer',
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
            'options.*' => 'required|integer|exists:options,id,show_status,1',
            'images' => 'array|max:10',
            'images.*.id' => 'integer',
            'images.*.image' => 'required|core_image',
            'images.*.rotate' => 'numeric'
        ];
    }
}