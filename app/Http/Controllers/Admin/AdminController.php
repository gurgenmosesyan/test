<?php

namespace App\Http\Controllers\Admin;

use App\Models\Admin\Admin;
use App\Models\Admin\Manager;
use App\Models\Admin\Search;
use App\Http\Requests\Admin\AdminRequest;
use App\Models\Language\Language;

class AdminController extends BaseController
{
    protected $manager = null;

    public function __construct(Manager $manager)
    {
        $this->manager = $manager;
    }

    public function table()
    {
        return view('admin.admin.index');
    }

    public function index(Search $search)
    {
        $result = $this->processDataTable($search);
        return $this->toDataTable($result);
    }

    public function create()
    {
        $admin = new Admin();
        $languages = Language::all();
        return view('admin.admin.edit')->with([
            'admin' => $admin,
            'languages' => $languages,
            'saveMode' => 'add'
        ]);
    }

    public function store(AdminRequest $request)
    {
        return $this->api('OK', $this->manager->store($request->all()));
    }

    public function edit($id)
    {
        $admin = Admin::findOrFail($id);
        $languages = Language::all();
        return view('admin.admin.edit')->with([
            'admin' => $admin,
            'languages' => $languages,
            'saveMode' => 'edit'
        ]);
    }

    public function update(AdminRequest $request, $id)
    {
        return $this->api('OK', $this->manager->update($id, $request->all()));
    }

    public function delete($id)
    {
        return $this->api('OK', $this->manager->delete($id));
    }
}