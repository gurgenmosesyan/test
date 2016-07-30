<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Model\Manager;
use App\Models\Part\Part;
use App\Models\Region\Region;

class ApiController extends Controller
{
    public function model(Request $request)
    {
        $markId = $request->input('mark_id');
        $onlyModel = $request->input('only_model');

        return $this->api('OK', Manager::getModelsWithCat($markId, $onlyModel));
    }

    public function part(Request $request)
    {
        $markId = $request->input('mark_id');
        $modelId = $request->input('model_id');

        $part = Part::where('mark_id', $markId)->where('model_id', $modelId)->first();
        $part = view('blocks.part')->with(['part' => $part])->render();
        return $this->api('OK', $part);
    }

    public function region(Request $request)
    {
        $countryId = $request->input('country_id');
        $regions = Region::joinMl()->active()->where('country_id', $countryId)->get();
        return $this->api('OK', $regions);
    }
}