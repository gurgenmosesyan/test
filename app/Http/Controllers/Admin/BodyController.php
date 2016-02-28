<?php

namespace App\Http\Controllers\Admin;

use App\Models\Body\Body;
use App\Models\Body\Manager;
use App\Models\Body\Search;
use App\Http\Requests\Admin\BodyRequest;
use App\Models\Language\Language;

class BodyController extends BaseController
{
    protected $manager = null;

    public function __construct(Manager $manager)
    {
        $this->manager = $manager;
    }

    public function table()
    {
        return view('admin.body.index');
    }

    public function index(Search $search)
    {
        $result = $this->processDataTable($search);
        return $this->toDataTable($result);
    }

    public function create()
    {
        $body = new Body();
        $languages = Language::all();
        return view('admin.body.edit')->with([
            'body' => $body,
            'languages' => $languages,
            'saveMode' => 'add'
        ]);
    }

    public function store(BodyRequest $request)
    {
        return $this->api('OK', $this->manager->store($request->all()));
    }

    public function edit($id)
    {
        $body = Body::active()->findOrFail($id);
        $languages = Language::all();
        return view('admin.body.edit')->with([
            'body' => $body,
            'languages' => $languages,
            'saveMode' => 'edit'
        ]);
    }

    public function update(BodyRequest $request, $id)
    {
        return $this->api('OK', $this->manager->update($id, $request->all()));
    }

    public function delete($id)
    {
        return $this->api('OK', $this->manager->delete($id));
    }
}