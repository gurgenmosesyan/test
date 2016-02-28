<?php

namespace App\Http\Controllers\Admin;

use App\Models\Cylinder\Cylinder;
use App\Models\Cylinder\Manager;
use App\Models\Cylinder\Search;
use App\Http\Requests\Admin\CylinderRequest;

class CylinderController extends BaseController
{
    protected $manager = null;

    public function __construct(Manager $manager)
    {
        $this->manager = $manager;
    }

    public function table()
    {
        return view('admin.cylinder.index');
    }

    public function index(Search $search)
    {
        $result = $this->processDataTable($search);
        return $this->toDataTable($result);
    }

    public function create()
    {
        $cylinder = new Cylinder();
        return view('admin.cylinder.edit')->with([
            'cylinder' => $cylinder,
            'saveMode' => 'add'
        ]);
    }

    public function store(CylinderRequest $request)
    {
        return $this->api('OK', $this->manager->store($request->all()));
    }

    public function edit($id)
    {
        $cylinder = Cylinder::findOrFail($id);
        return view('admin.cylinder.edit')->with([
            'cylinder' => $cylinder,
            'saveMode' => 'edit']);

    }

    public function update(CylinderRequest $request, $id)
    {
        return $this->api('OK', $this->manager->update($id, $request->all()));
    }

    public function delete($id)
    {
        return $this->api('OK', $this->manager->delete($id));
    }
}