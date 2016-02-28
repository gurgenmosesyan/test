<?php

namespace App\Http\Controllers\Admin;

use App\Models\Option\Option;
use App\Models\Option\Manager;
use App\Models\Option\Search;
use App\Http\Requests\Admin\OptionRequest;
use App\Models\Language\Language;

class OptionController extends BaseController
{
    protected $manager = null;

    public function __construct(Manager $manager)
    {
        $this->manager = $manager;
    }

    public function table()
    {
        return view('admin.option.index');
    }

    public function index(Search $search)
    {
        $result = $this->processDataTable($search);
        return $this->toDataTable($result);
    }

    public function create()
    {
        $option = new Option();
        $languages = Language::all();
        return view('admin.option.edit')->with([
            'option' => $option,
            'languages' => $languages,
            'saveMode' => 'add'
        ]);
    }

    public function store(OptionRequest $request)
    {
        return $this->api('OK', $this->manager->store($request->all()));
    }

    public function edit($id)
    {
        $option = Option::active()->findOrFail($id);
        $languages = Language::all();
        return view('admin.option.edit')->with([
            'option' => $option,
            'languages' => $languages,
            'saveMode' => 'edit'
        ]);
    }

    public function update(OptionRequest $request, $id)
    {
        return $this->api('OK', $this->manager->update($id, $request->all()));
    }

    public function delete($id)
    {
        return $this->api('OK', $this->manager->delete($id));
    }
}