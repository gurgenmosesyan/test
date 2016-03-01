<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Core\BaseController;
use App\Models\InteriorColor\Color;
use App\Models\InteriorColor\Manager;
use App\Models\InteriorColor\Search;
use App\Http\Requests\Admin\InteriorColorRequest;
use App\Models\Language\Language;

class InteriorColorController extends BaseController
{
    protected $manager = null;

    public function __construct(Manager $manager)
    {
        $this->manager = $manager;
    }

    public function table()
    {
        return view('admin.interior_color.index');
    }

    public function index(Search $search)
    {
        $result = $this->processDataTable($search);
        return $this->toDataTable($result);
    }

    public function create()
    {
        $color = new Color();
        $languages = Language::all();
        return view('admin.interior_color.edit')->with([
            'color' => $color,
            'languages' => $languages,
            'saveMode' => 'add'
        ]);
    }

    public function store(InteriorColorRequest $request)
    {
        return $this->api('OK', $this->manager->store($request->all()));
    }

    public function edit($id)
    {
        $color = Color::active()->findOrFail($id);
        $languages = Language::all();
        return view('admin.interior_color.edit')->with([
            'color' => $color,
            'languages' => $languages,
            'saveMode' => 'edit'
        ]);
    }

    public function update(InteriorColorRequest $request, $id)
    {
        return $this->api('OK', $this->manager->update($id, $request->all()));
    }

    public function delete($id)
    {
        return $this->api('OK', $this->manager->delete($id));
    }
}