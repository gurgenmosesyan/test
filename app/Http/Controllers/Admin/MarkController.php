<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Core\BaseController;
use App\Models\Mark\Mark;
use App\Models\Mark\Manager;
use App\Models\Mark\Search;
use App\Http\Requests\Admin\MarkRequest;

class MarkController extends BaseController
{
    protected $manager = null;

    public function __construct(Manager $manager)
    {
        $this->manager = $manager;
    }

    public function table()
    {
        return view('admin.mark.index');
    }

    public function index(Search $search)
    {
        $result = $this->processDataTable($search);
        return $this->toDataTable($result);
    }

    public function create()
    {
        $mark = new Mark();
        return view('admin.mark.edit')->with([
            'mark' => $mark,
            'saveMode' => 'add'
        ]);
    }

    public function store(MarkRequest $request)
    {
        return $this->api('OK', $this->manager->store($request->all()));
    }

    public function edit($id)
    {
        $mark = Mark::findOrFail($id);
        return view('admin.mark.edit')->with([
            'mark' => $mark,
            'saveMode' => 'edit']);

    }

    public function update(MarkRequest $request, $id)
    {
        return $this->api('OK', $this->manager->update($id, $request->all()));
    }

    public function delete($id)
    {
        return $this->api('OK', $this->manager->delete($id));
    }
}