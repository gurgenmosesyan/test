<?php

namespace App\Models\Config;

use App\Core\Image\SaveImage;
use Cache;
use DB;

class Manager
{
    public static function getAutoEmpty()
    {
        $cacheKey = 'auto_empty';
        $data = Cache::get($cacheKey);
        if ($data == null) {
            $data = Config::where('key', Config::KEY_AUTO_EMPTY)->first();
            Cache::forever($cacheKey, $data);
        }
        return $data;
    }

    public function update($data)
    {
        $configs = Config::all();
        DB::transaction(function() use($configs, $data) {
            $watermark = $autoEmpty = null;
            foreach ($configs as $config) {
                if ($config->key == Config::KEY_WATERMARK) {
                    $watermark = $config;
                } else if ($config->key == Config::KEY_AUTO_EMPTY) {
                    $autoEmpty = $config;
                }
            }
            $this->updateWatermark($data['watermark'], $watermark);
            $this->updateAutoEmpty($data['auto_empty'], $autoEmpty);
            $this->removeCache();
        });
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

    protected function updateAutoEmpty($data, $autoEmpty)
    {
        if ($autoEmpty == null) {
            $autoEmpty = new Config();
            $autoEmpty->key = Config::KEY_AUTO_EMPTY;
        }
        SaveImage::save($data, $autoEmpty, 'value');
        $autoEmpty->save();
    }

    protected function removeCache()
    {
        Cache::forget('auto_empty');
    }
}