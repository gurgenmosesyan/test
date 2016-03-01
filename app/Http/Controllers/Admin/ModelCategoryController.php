<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Core\BaseController;
use App\Models\ModelCategory\Category;
use App\Models\ModelCategory\Manager;
use App\Models\ModelCategory\Search;
use App\Http\Requests\Admin\ModelCategoryRequest;
use App\Models\Mark\Mark;
use Illuminate\Http\Request;

class ModelCategoryController extends BaseController
{
    protected $manager = null;

    public function __construct(Manager $manager)
    {
        $this->manager = $manager;
    }

    public function table()
    {
        return view('admin.model_category.index');
    }

    public function index(Search $search)
    {
        $result = $this->processDataTable($search);
        return $this->toDataTable($result);
    }

    public function create()
    {
        $category = new Category();
        $marks = Mark::active()->get();
        return view('admin.model_category.edit')->with([
            'category' => $category,
            'marks' => $marks,
            'saveMode' => 'add'
        ]);
    }

    public function store(ModelCategoryRequest $request)
    {
        return $this->api('OK', $this->manager->store($request->all()));
    }

    public function edit($id)
    {
        $category = Category::findOrFail($id);
        $marks = Mark::active()->get();
        return view('admin.model_category.edit')->with([
            'category' => $category,
            'marks' => $marks,
            'saveMode' => 'edit']);

    }

    public function update(ModelCategoryRequest $request, $id)
    {
        return $this->api('OK', $this->manager->update($id, $request->all()));
    }

    public function delete($id)
    {
        return $this->api('OK', $this->manager->delete($id));
    }

    public function get(Request $request)
    {
        $markId = $request->input('mark_id');
        $categories = Category::active()->where('mark_id', $markId)->get();
        return $this->api('OK', $categories);
    }
}