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
        $autoEmpty = null;
        foreach ($configs as $config) {
            if ($config->key == Config::KEY_WATERMARK) {
                $watermark = $config->value;
            } else if ($config->key == Config::KEY_AUTO_EMPTY) {
                $autoEmpty = $config->value;
            }
        }
        return view('admin.config.edit')->with([
            'watermark' => $watermark,
            'autoEmpty' => $autoEmpty
        ]);
    }

    public function update(ConfigRequest $request)
    {
        $this->manager->update($request->all());
        return $this->api('OK');
    }
}