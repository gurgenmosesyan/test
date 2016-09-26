<?php

namespace App\Http\Controllers\Core;

use App\Core\Admin\Admin;
use App\Core\Admin\Manager;
use App\Core\Admin\Search;
use App\Http\Requests\Core\AdminRequest;
use App\Http\Requests\Core\ProfileRequest;
use App\Core\Language\Language;
use Auth;

class AdminController extends BaseController
{
    protected $manager = null;

    public function __construct(Manager $manager)
    {
        $this->manager = $manager;
    }

    public function table()
    {
        return view('core.admin.index');
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
        return view('core.admin.edit')->with([
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
        return view('core.admin.edit')->with([
            'admin' => $admin,
            'languages' => $languages,
            'saveMode' => 'edit'
        ]);
    }

    public function update(AdminRequest $request, $id)
    {
        return $this->api('OK', $this->manager->update($id, $request->all()));
    }

    public function profile()
    {
        $admin = Auth::guard('admin')->user();
        $languages = Language::all();
        return view('core.admin.profile')->with([
            'admin' => $admin,
            'languages' => $languages,
        ]);
    }

    public function profileUpdate(ProfileRequest $request)
    {
        $admin = Auth::guard('admin')->user();
        $data = $request->all();
        $data['permissions'] = $admin->permissions;
        return $this->api('OK', $this->manager->update($admin->id, $data));
    }

    public function delete($id)
    {
        return $this->api('OK', $this->manager->delete($id));
    }
}