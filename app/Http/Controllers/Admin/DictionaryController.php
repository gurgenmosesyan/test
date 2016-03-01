<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Core\BaseController;
use App\Models\Dictionary\Manager;
use App\Models\Dictionary\Search;
use App\Http\Requests\Admin\DictionaryRequest;
use App\Models\Language\Language;
use Illuminate\Http\Request;

class DictionaryController extends BaseController
{
    protected $manager = null;

    public function __construct(Manager $manager)
    {
        $this->manager = $manager;
    }

    public function table(Request $request)
    {
        $appId = $request->input('app') == '2' ? '2' : '1';
        $languages = Language::all();
        return view('admin.dictionary.index')->with(['languages' => $languages, 'appId' => $appId]);
    }

    public function index(Search $search)
    {
        $result = $this->processDataTable($search);
        return $this->toDataTable($result);
    }

    public function update(DictionaryRequest $request)
    {
        return $this->api('OK', $this->manager->update($request->all()));
    }

    public function delete(Request $request)
    {
        $key = $request->input('key');
        $appId = $request->input('app_id');
        return $this->api('OK', $this->manager->delete($key, $appId));
    }
}