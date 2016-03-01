<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Core\BaseController;
use App\Models\Train\Train;
use App\Models\Train\Manager;
use App\Models\Train\Search;
use App\Http\Requests\Admin\TrainRequest;
use App\Models\Language\Language;

class TrainController extends BaseController
{
    protected $manager = null;

    public function __construct(Manager $manager)
    {
        $this->manager = $manager;
    }

    public function table()
    {
        return view('admin.train.index');
    }

    public function index(Search $search)
    {
        $result = $this->processDataTable($search);
        return $this->toDataTable($result);
    }

    public function create()
    {
        $train = new Train();
        $languages = Language::all();
        return view('admin.train.edit')->with([
            'train' => $train,
            'languages' => $languages,
            'saveMode' => 'add'
        ]);
    }

    public function store(TrainRequest $request)
    {
        return $this->api('OK', $this->manager->store($request->all()));
    }

    public function edit($id)
    {
        $train = Train::active()->findOrFail($id);
        $languages = Language::all();
        return view('admin.train.edit')->with([
            'train' => $train,
            'languages' => $languages,
            'saveMode' => 'edit'
        ]);
    }

    public function update(TrainRequest $request, $id)
    {
        return $this->api('OK', $this->manager->update($id, $request->all()));
    }

    public function delete($id)
    {
        return $this->api('OK', $this->manager->delete($id));
    }
}