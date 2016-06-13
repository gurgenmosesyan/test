<?php

namespace App\Http\Requests\Admin;

use App\Http\Requests\Request;
use App\Models\Body\Body;

class BodyRequest extends Request
{
    public function rules()
    {
        $showInSearch = $this->get('show_in_search');
        $imageReq = '';
        if ($showInSearch == Body::SHOW_IN_SEARCH) {
            $imageReq = 'required|';
        }

        return [
            'show_in_search' => 'in:'.Body::NOT_SHOW_IN_SEARCH.','.Body::SHOW_IN_SEARCH,
            'image' => $imageReq.'core_image',
            'sort_order' => 'integer',
            'ml' => 'ml',
            'ml.*.name' => 'required|max:255'
        ];
    }
}