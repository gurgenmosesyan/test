<?php

namespace App\Http\Controllers\Admin;

use App\Models\Country\Country;
use App\Models\Country\Manager;
use App\Models\Country\Search;
use App\Http\Requests\Admin\CountryRequest;
use App\Models\Language\Language;

class CountryController extends BaseController
{
    protected $manager = null;

    public function __construct(Manager $manager)
    {
        $this->manager = $manager;
    }

    public function table()
    {
        return view('admin.country.index');
    }

    public function index(Search $search)
    {
        $result = $this->processDataTable($search);
        return $this->toDataTable($result);
    }

    public function create()
    {
        $country = new Country();
        $languages = Language::all();
        return view('admin.country.edit')->with([
            'country' => $country,
            'languages' => $languages,
            'saveMode' => 'add'
        ]);
    }

    public function store(CountryRequest $request)
    {
        return $this->api('OK', $this->manager->store($request->all()));
    }

    public function edit($id)
    {
        $country = Country::active()->findOrFail($id);
        $languages = Language::all();
        return view('admin.country.edit')->with([
            'country' => $country,
            'languages' => $languages,
            'saveMode' => 'edit'
        ]);
    }

    public function update(CountryRequest $request, $id)
    {
        return $this->api('OK', $this->manager->update($id, $request->all()));
    }

    public function delete($id)
    {
        return $this->api('OK', $this->manager->delete($id));
    }
}