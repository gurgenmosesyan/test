<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Core\BaseController;
use App\Models\Wheel\Wheel;
use App\Models\Wheel\Manager;
use App\Models\Wheel\Search;
use App\Http\Requests\Admin\WheelRequest;

class WheelController extends BaseController
{
    protected $manager = null;

    public function __construct(Manager $manager)
    {
        $this->manager = $manager;
    }

    public function table()
    {
        return view('admin.wheel.index');
    }

    public function index(Search $search)
    {
        $result = $this->processDataTable($search);
        return $this->toDataTable($result);
    }

    public function create()
    {
        $wheel = new Wheel();
        return view('admin.wheel.edit')->with([
            'wheel' => $wheel,
            'saveMode' => 'add'
        ]);
    }

    public function store(WheelRequest $request)
    {
        return $this->api('OK', $this->manager->store($request->all()));
    }

    public function edit($id)
    {
        $wheel = Wheel::findOrFail($id);
        return view('admin.wheel.edit')->with([
            'wheel' => $wheel,
            'saveMode' => 'edit']);

    }

    public function update(WheelRequest $request, $id)
    {
        return $this->api('OK', $this->manager->update($id, $request->all()));
    }

    public function delete($id)
    {
        return $this->api('OK', $this->manager->delete($id));
    }
}