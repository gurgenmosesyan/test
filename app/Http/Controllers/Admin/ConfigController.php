<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Core\BaseController;
use App\Models\Config\Config;
use App\Models\Config\Manager;
use App\Http\Requests\Admin\ConfigRequest;

class ConfigController extends BaseController
{
    protected $manager = null;

    public function __construct(Manager $manager)
    {
        $this->manager = $manager;
    }

    public function edit()
    {
        $configs = Config::all();
        $watermark = null;
        foreach ($configs as $config) {
            if ($config->key == 'watermark') {
                $watermark = $config->value;
            }
        }
        return view('admin.config.edit')->with([
            'watermark' => $watermark,
        ]);
    }

    public function update(ConfigRequest $request)
    {
        $this->manager->update($request->all());
        return $this->api('OK');
    }
}