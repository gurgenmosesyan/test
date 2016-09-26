<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Core\BaseController;
use App\Models\Tax\Tax;
use App\Models\Tax\Manager;
use App\Models\Tax\Search;
use App\Http\Requests\Admin\TaxRequest;
use App\Models\Engine\Engine;
use App\Models\Mark\Mark;
use App\Models\Model\Model;
use App\Models\Currency\Currency;

class TaxController extends BaseController
{
    protected $manager = null;

    public function __construct(Manager $manager)
    {
        $this->manager = $manager;
    }

    public function table()
    {
        return view('admin.tax.index');
    }

    public function index(Search $search)
    {
        $result = $this->processDataTable($search);
        return $this->toDataTable($result);
    }

    public function create()
    {
        $tax = new Tax();
        $marks = Mark::active()->get();
        $engines = Engine::active()->with('current')->get();
        $currencies = Currency::active()->ordered()->get();

        return view('admin.tax.edit')->with([
            'tax' => $tax,
            'marks' => $marks,
            'models' => [],
            'engines' => $engines,
            'currencies' => $currencies,
            'saveMode' => 'add'
        ]);
    }

    public function store(TaxRequest $request)
    {
        $this->manager->store($request->all());
        return $this->api('OK');
    }

    public function edit($id)
    {
        $tax = Tax::findOrFail($id);
        $marks = Mark::active()->get();
        $models = Model::active()->where('mark_id', $tax->mark_id)->get();
        $engines = Engine::active()->with('current')->get();
        $currencies = Currency::active()->ordered()->get();

        return view('admin.tax.edit')->with([
            'tax' => $tax,
            'marks' => $marks,
            'models' => $models,
            'engines' => $engines,
            'currencies' => $currencies,
            'saveMode' => 'edit'
        ]);
    }

    public function update(TaxRequest $request, $id)
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