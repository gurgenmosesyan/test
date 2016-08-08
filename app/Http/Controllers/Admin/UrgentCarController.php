<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Core\BaseController;
use App\Models\UrgentCar\UrgentCar;
use App\Models\UrgentCar\Manager;
use App\Models\UrgentCar\Search;
use App\Http\Requests\Admin\UrgentCarRequest;

class UrgentCarController extends BaseController
{
    protected $manager = null;

    public function __construct(Manager $manager)
    {
        $this->manager = $manager;
    }

    public function table()
    {
        return view('admin.urgent_car.index');
    }

    public function index(Search $search)
    {
        $result = $this->processDataTable($search);
        return $this->toDataTable($result);
    }

    public function create()
    {
        $urgentCar = new UrgentCar();

        return view('admin.urgent_car.edit')->with([
            'urgentCar' => $urgentCar,
            'autoName' => '',
            'saveMode' => 'add'
        ]);
    }

    public function store(UrgentCarRequest $request)
    {
        $this->manager->store($request->all());
        return $this->api('OK');
    }

    public function edit($id)
    {
        $urgentCar = UrgentCar::active()->findOrFail($id);
        $autoName = $urgentCar->auto->mark->name.' '.$urgentCar->auto->model->name.' ('.$urgentCar->auto->year.')';

        return view('admin.urgent_car.edit')->with([
            'urgentCar' => $urgentCar,
            'autoName' => $autoName,
            'saveMode' => 'edit'
        ]);
    }

    public function update(UrgentCarRequest $request, $id)
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