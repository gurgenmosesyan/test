<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Core\BaseController;
use App\Models\TopCar\TopCar;
use App\Models\TopCar\Manager;
use App\Models\TopCar\Search;
use App\Http\Requests\Admin\TopCarRequest;

class TopCarController extends BaseController
{
    protected $manager = null;

    public function __construct(Manager $manager)
    {
        $this->manager = $manager;
    }

    public function table()
    {
        return view('admin.top_car.index');
    }

    public function index(Search $search)
    {
        $result = $this->processDataTable($search);
        return $this->toDataTable($result);
    }

    public function create()
    {
        $topCar = new TopCar();

        return view('admin.top_car.edit')->with([
            'topCar' => $topCar,
            'autoName' => '',
            'saveMode' => 'add'
        ]);
    }

    public function store(TopCarRequest $request)
    {
        $this->manager->store($request->all());
        return $this->api('OK');
    }

    public function edit($id)
    {
        $topCar = TopCar::active()->findOrFail($id);
        $autoName = $topCar->auto->mark->name.' '.$topCar->auto->model->name.' ('.$topCar->auto->year.')';

        return view('admin.top_car.edit')->with([
            'topCar' => $topCar,
            'autoName' => $autoName,
            'saveMode' => 'edit'
        ]);
    }

    public function update(TopCarRequest $request, $id)
    {
        $this->manager->update($id, $request->all());
        return $this->api('OK');
    }

    public function delete($id)
    {
        $this->manager->delete($id);
        return $this->api('OK');
    }
}