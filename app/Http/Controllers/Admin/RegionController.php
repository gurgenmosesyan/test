<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Core\BaseController;
use App\Models\Region\Region;
use App\Models\Region\Manager;
use App\Models\Region\Search;
use App\Http\Requests\Admin\RegionRequest;
use App\Models\Language\Language;
use App\Models\Country\Country;
use Illuminate\Http\Request;

class RegionController extends BaseController
{
    protected $manager = null;

    public function __construct(Manager $manager)
    {
        $this->manager = $manager;
    }

    public function table()
    {
        return view('admin.region.index');
    }

    public function index(Search $search)
    {
        $result = $this->processDataTable($search);
        return $this->toDataTable($result);
    }

    public function create()
    {
        $region = new Region();
        $languages = Language::all();
        $countries = Country::active()->with('current')->get();
        return view('admin.region.edit')->with([
            'region' => $region,
            'languages' => $languages,
            'countries' => $countries,
            'saveMode' => 'add'
        ]);
    }

    public function store(RegionRequest $request)
    {
        return $this->api('OK', $this->manager->store($request->all()));
    }

    public function edit($id)
    {
        $region = Region::active()->findOrFail($id);
        $languages = Language::all();
        $countries = Country::active()->with('current')->get();
        return view('admin.region.edit')->with([
            'region' => $region,
            'languages' => $languages,
            'countries' => $countries,
            'saveMode' => 'edit'
        ]);
    }

    public function update(RegionRequest $request, $id)
    {
        return $this->api('OK', $this->manager->update($id, $request->all()));
    }

    public function delete($id)
    {
        return $this->api('OK', $this->manager->delete($id));
    }

    public function get(Request $request)
    {
        $countryId = $request->input('country_id');
        $regions = Region::select('regions.id', 'ml.name')
            ->join('regions_ml AS ml', function($query) {
                $query->on('ml.id', '=', 'regions.id')->where('ml.lng_id', '=', cLng('id'));
            })
            ->where('regions.country_id', $countryId)
            ->where('regions.show_status', Region::STATUS_ACTIVE)
            ->get();

        return $this->api('OK', $regions);
    }
}