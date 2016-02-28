<?php

namespace App\Http\Controllers\Admin;

use App\Models\Model\Model;
use App\Models\Model\Manager;
use App\Models\Model\Search;
use App\Http\Requests\Admin\ModelRequest;
use App\Models\Mark\Mark;
use App\Models\ModelCategory\Category;

class ModelController extends BaseController
{
    protected $manager = null;

    public function __construct(Manager $manager)
    {
        $this->manager = $manager;
    }

    public function table()
    {
        return view('admin.model.index');
    }

    public function index(Search $search)
    {
        $result = $this->processDataTable($search);
        return $this->toDataTable($result);
    }

    public function create()
    {
        $model = new Model();
        $marks = Mark::active()->get();
        return view('admin.model.edit')->with([
            'model' => $model,
            'marks' => $marks,
            'categories' => collect(),
            'saveMode' => 'add'
        ]);
    }

    public function store(ModelRequest $request)
    {
        return $this->api('OK', $this->manager->store($request->all()));
    }

    public function edit($id)
    {
        $model = Model::findOrFail($id);
        $marks = Mark::active()->get();
        $categories = Category::active()->where('mark_id', $model->mark_id)->get();
        return view('admin.model.edit')->with([
            'model' => $model,
            'marks' => $marks,
            'categories' => $categories,
            'saveMode' => 'edit']);

    }

    public function update(ModelRequest $request, $id)
    {
        return $this->api('OK', $this->manager->update($id, $request->all()));
    }

    public function delete($id)
    {
        return $this->api('OK', $this->manager->delete($id));
    }
}