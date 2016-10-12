<?php

namespace App\Http\Controllers;

use App\Http\Requests\TaxRequest;
use App\Models\Tax\Tax;
use App\Models\Tax\Manager as TaxManager;
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

    public function tax(TaxRequest $request)
    {
        $data = $request->all();

        $tax = Tax::where('mark_id', $data['mark_id'])->where('model_id', $data['model_id'])
                ->where('year', $data['year'])->where('engine_id', $data['engine_id'])
                ->where('volume', $data['volume'])->first();
        if ($tax == null) {
            return $this->api('NOT_FOUND', ['message' => trans('www.tax.not_found')]);
        }

        return $this->api('OK', TaxManager::calculate($tax));
    }

    public function region(Request $request)
    {
        $countryId = $request->input('country_id');
        $regions = Region::joinMl()->active()->where('country_id', $countryId)->get();
        return $this->api('OK', $regions);
    }
}