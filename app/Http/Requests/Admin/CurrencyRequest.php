<?php

namespace App\Http\Requests\Admin;

use App\Http\Requests\Request;
use App\Models\Currency\Currency;

class CurrencyRequest extends Request
{
    public function rules()
    {
        $default = $this->get('default');
        $rateRule = 'required|';
        if ($default == Currency::IS_DEFAULT) {
            $rateRule = '';
        }

        return [
            'code' => 'required|max:50',
            'default' => 'in:'.Currency::IS_DEFAULT.','.Currency::IS_NOT_DEFAULT,
            'rate' => $rateRule.'numeric',
            'icon' => 'required|core_image',
            'sort_order' => 'integer',
        ];
    }
}