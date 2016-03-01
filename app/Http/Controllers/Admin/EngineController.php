<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Core\BaseController;
use App\Models\Engine\Engine;
use App\Models\Engine\Manager;
use App\Models\Engine\Search;
use App\Http\Requests\Admin\EngineRequest;
use App\Models\Language\Language;

class EngineController extends BaseController
{
    protected $manager = null;

    public function __construct(Manager $manager)
    {
        $this->manager = $manager;
    }

    public function table()
    {
        return view('admin.engine.index');
    }

    public function index(Search $search)
    {
        $result = $this->processDataTable($search);
        return $this->toDataTable($result);
    }

    public function create()
    {
        $engine = new Engine();
        $languages = Language::all();
        return view('admin.engine.edit')->with([
            'engine' => $engine,
            'languages' => $languages,
            'saveMode' => 'add'
        ]);
    }

    public function store(EngineRequest $request)
    {
        return $this->api('OK', $this->manager->store($request->all()));
    }

    public function edit($id)
    {
        $engine = Engine::active()->findOrFail($id);
        $languages = Language::all();
        return view('admin.engine.edit')->with([
            'engine' => $engine,
            'languages' => $languages,
            'saveMode' => 'edit'
        ]);
    }

    public function update(EngineRequest $request, $id)
    {
        return $this->api('OK', $this->manager->update($id, $request->all()));
    }

    public function delete($id)
    {
        return $this->api('OK', $this->manager->delete($id));
    }
}