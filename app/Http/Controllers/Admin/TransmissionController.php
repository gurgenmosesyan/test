<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Core\BaseController;
use App\Models\Transmission\Transmission;
use App\Models\Transmission\Manager;
use App\Models\Transmission\Search;
use App\Http\Requests\Admin\TransmissionRequest;
use App\Core\Language\Language;

class TransmissionController extends BaseController
{
    protected $manager = null;

    public function __construct(Manager $manager)
    {
        $this->manager = $manager;
    }

    public function table()
    {
        return view('admin.transmission.index');
    }

    public function index(Search $search)
    {
        $result = $this->processDataTable($search);
        return $this->toDataTable($result);
    }

    public function create()
    {
        $transmission = new Transmission();
        $languages = Language::all();
        return view('admin.transmission.edit')->with([
            'transmission' => $transmission,
            'languages' => $languages,
            'saveMode' => 'add'
        ]);
    }

    public function store(TransmissionRequest $request)
    {
        return $this->api('OK', $this->manager->store($request->all()));
    }

    public function edit($id)
    {
        $transmission = Transmission::active()->findOrFail($id);
        $languages = Language::all();
        return view('admin.transmission.edit')->with([
            'transmission' => $transmission,
            'languages' => $languages,
            'saveMode' => 'edit'
        ]);
    }

    public function update(TransmissionRequest $request, $id)
    {
        return $this->api('OK', $this->manager->update($id, $request->all()));
    }

    public function delete($id)
    {
        return $this->api('OK', $this->manager->delete($id));
    }
}