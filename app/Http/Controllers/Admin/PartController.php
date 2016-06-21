<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Core\BaseController;
use App\Models\Part\Part;
use App\Models\Part\Manager;
use App\Models\Part\Search;
use App\Http\Requests\Admin\PartRequest;
use App\Models\Mark\Mark;
use App\Models\Model\Model;
use App\Models\Currency\Currency;

class PartController extends BaseController
{
    protected $manager = null;

    public function __construct(Manager $manager)
    {
        $this->manager = $manager;
    }

    public function table()
    {
        $marks = Mark::active()->get();
        return view('admin.part.index')->with(['marks' => $marks]);
    }

    public function index(Search $search)
    {
        $result = $this->processDataTable($search);
        return $this->toDataTable($result);
    }

    public function create()
    {
        $part = new Part();
        $marks = Mark::active()->get();
        $currencies = Currency::active()->ordered()->get();
        return view('admin.part.edit')->with([
            'part' => $part,
            'marks' => $marks,
            'models' => [],
            'currencies' => $currencies,
            'saveMode' => 'add'
        ]);
    }

    public function store(PartRequest $request)
    {
        $this->manager->store($request->all());
        return $this->api('OK');
    }

    public function edit($id)
    {
        $part = Part::findOrFail($id);
        $marks = Mark::active()->get();
        $models = Model::active()->where('mark_id', $part->mark_id)->get();
        $currencies = Currency::active()->ordered()->get();
        return view('admin.part.edit')->with([
            'part' => $part,
            'marks' => $marks,
            'models' => $models,
            'currencies' => $currencies,
            'saveMode' => 'edit'
        ]);
    }

    public function update(PartRequest $request, $id)
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