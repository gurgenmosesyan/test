<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Core\BaseController;
use App\Models\Currency\Currency;
use App\Models\Currency\Manager;
use App\Models\Currency\Search;
use App\Http\Requests\Admin\CurrencyRequest;

class CurrencyController extends BaseController
{
    protected $manager = null;

    public function __construct(Manager $manager)
    {
        $this->manager = $manager;
    }

    public function table()
    {
        return view('admin.currency.index');
    }

    public function index(Search $search)
    {
        $result = $this->processDataTable($search);
        return $this->toDataTable($result);
    }

    public function create()
    {
        $currency = new Currency();
        return view('admin.currency.edit')->with(['currency' => $currency, 'saveMode' => 'add']);
    }

    public function store(CurrencyRequest $request)
    {
        return $this->api('OK', $this->manager->store($request->all()));
    }

    public function edit($id)
    {
        $currency = Currency::findOrFail($id);
        return view('admin.currency.edit')->with(['currency' => $currency, 'saveMode' => 'edit']);
    }

    public function update(CurrencyRequest $request, $id)
    {
        return $this->api('OK', $this->manager->update($id, $request->all()));
    }

    public function delete($id)
    {
        return $this->api('OK', $this->manager->delete($id));
    }
}