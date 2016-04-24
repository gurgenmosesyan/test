<?php

namespace App\Models\Config;

use App\Core\Image\SaveImage;

class Manager
{
    public function update($data)
    {
        $configs = Config::all();
        $watermark = null;
        foreach ($configs as $config) {
            if ($config->key == Config::KEY_WATERMARK) {
                $watermark = $config;
            }
        }
        $this->updateWatermark($data['watermark'], $watermark);
    }

    protected function updateWatermark($data, $watermark)
    {
        if ($watermark == null) {
            $watermark = new Config();
            $watermark->key = Config::KEY_WATERMARK;
        }
        SaveImage::save($data, $watermark, 'value');
        $watermark->save();
    }
}