<?php

namespace App\Http\Controllers\Admin;

use App\Models\Color\Color;
use App\Models\Color\Manager;
use App\Models\Color\Search;
use App\Http\Requests\Admin\ColorRequest;
use App\Models\Language\Language;

class ColorController extends BaseController
{
    protected $manager = null;

    public function __construct(Manager $manager)
    {
        $this->manager = $manager;
    }

    public function table()
    {
        return view('admin.color.index');
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
        return view('admin.color.edit')->with([
            'color' => $color,
            'languages' => $languages,
            'saveMode' => 'add'
        ]);
    }

    public function store(ColorRequest $request)
    {
        return $this->api('OK', $this->manager->store($request->all()));
    }

    public function edit($id)
    {
        $color = Color::active()->findOrFail($id);
        $languages = Language::all();
        return view('admin.color.edit')->with([
            'color' => $color,
            'languages' => $languages,
            'saveMode' => 'edit'
        ]);
    }

    public function update(ColorRequest $request, $id)
    {
        return $this->api('OK', $this->manager->update($id, $request->all()));
    }

    public function delete($id)
    {
        return $this->api('OK', $this->manager->delete($id));
    }
}