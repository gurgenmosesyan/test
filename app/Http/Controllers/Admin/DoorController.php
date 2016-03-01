<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Core\BaseController;
use App\Models\Door\Door;
use App\Models\Door\Manager;
use App\Models\Door\Search;
use App\Http\Requests\Admin\DoorRequest;

class DoorController extends BaseController
{
    protected $manager = null;

    public function __construct(Manager $manager)
    {
        $this->manager = $manager;
    }

    public function table()
    {
        return view('admin.door.index');
    }

    public function index(Search $search)
    {
        $result = $this->processDataTable($search);
        return $this->toDataTable($result);
    }

    public function create()
    {
        $door = new Door();
        return view('admin.door.edit')->with([
            'door' => $door,
            'saveMode' => 'add'
        ]);
    }

    public function store(DoorRequest $request)
    {
        return $this->api('OK', $this->manager->store($request->all()));
    }

    public function edit($id)
    {
        $door = Door::findOrFail($id);
        return view('admin.door.edit')->with([
            'door' => $door,
            'saveMode' => 'edit']);

    }

    public function update(DoorRequest $request, $id)
    {
        return $this->api('OK', $this->manager->update($id, $request->all()));
    }

    public function delete($id)
    {
        return $this->api('OK', $this->manager->delete($id));
    }
}