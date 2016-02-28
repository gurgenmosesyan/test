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
            'model_category_id' => 'required|integer|exists:model_categories,id,mark_id,'.$markId,
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
            'year' => 'required|integer|max:4',
            'mileage' => 'required|integer',
            'mileage_measurement' => 'required|in:'.Auto::MILEAGE_MEASUREMENT_KM.','.Auto::MILEAGE_MEASUREMENT_MILE,
            'volume_1' => 'required_with:volume_2|integer|max:15',
            'volume_2' => 'required_with:volume_1|integer|max:15',
            'horsepower' => 'integer|max:4',
            'place' => 'max:255'
        ];
    }
}