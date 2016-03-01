<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Core\BaseController;
use App\Models\Language\Language;
use App\Models\Language\Manager;
use App\Models\Language\Search;
use App\Http\Requests\Admin\LanguageRequest;

class LanguageController extends BaseController
{
    protected $manager = null;

    public function __construct(Manager $manager)
    {
        $this->manager = $manager;
    }

    public function table()
    {
        return view('admin.language.index');
    }

    public function index(Search $search)
    {
        $result = $this->processDataTable($search);
        return $this->toDataTable($result);
    }

    public function create()
    {
        $language = new Language();
        return view('admin.language.edit')->with(['language' => $language, 'saveMode' => 'add']);
    }

    public function store(LanguageRequest $request)
    {
        return $this->api('OK', $this->manager->store($request->all()));
    }

    public function edit($id)
    {
        $language = Language::findOrFail($id);
        return view('admin.language.edit')->with(['language' => $language, 'saveMode' => 'edit']);
    }

    public function update(LanguageRequest $request, $id)
    {
        return $this->api('OK', $this->manager->update($id, $request->all()));
    }

    public function delete($id)
    {
        return $this->api('OK', $this->manager->delete($id));
    }
}