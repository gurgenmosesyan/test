<?php

namespace App\Http\Controllers\Admin;

use App\Models\Rudder\Rudder;
use App\Models\Rudder\Manager;
use App\Models\Rudder\Search;
use App\Http\Requests\Admin\RudderRequest;
use App\Models\Language\Language;

class RudderController extends BaseController
{
    protected $manager = null;

    public function __construct(Manager $manager)
    {
        $this->manager = $manager;
    }

    public function table()
    {
        return view('admin.rudder.index');
    }

    public function index(Search $search)
    {
        $result = $this->processDataTable($search);
        return $this->toDataTable($result);
    }

    public function create()
    {
        $rudder = new Rudder();
        $languages = Language::all();
        return view('admin.rudder.edit')->with([
            'rudder' => $rudder,
            'languages' => $languages,
            'saveMode' => 'add'
        ]);
    }

    public function store(RudderRequest $request)
    {
        return $this->api('OK', $this->manager->store($request->all()));
    }

    public function edit($id)
    {
        $rudder = Rudder::active()->findOrFail($id);
        $languages = Language::all();
        return view('admin.rudder.edit')->with([
            'rudder' => $rudder,
            'languages' => $languages,
            'saveMode' => 'edit'
        ]);
    }

    public function update(RudderRequest $request, $id)
    {
        return $this->api('OK', $this->manager->update($id, $request->all()));
    }

    public function delete($id)
    {
        return $this->api('OK', $this->manager->delete($id));
    }
}