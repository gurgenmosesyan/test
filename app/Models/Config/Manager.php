<?php

namespace App\Models\Config;

use App\Core\Image\SaveImage;
use App\Core\Language\Language;
use Cache;
use DB;

class Manager
{
    public static function getLogo()
    {
        $cacheKey = 'logo_'.cLng('id');
        $data = Cache::get($cacheKey);
        if ($data == null) {
            $data = Config::joinMl()->where('config.key', Config::KEY_LOGO)->first();
            $data = '/images/config/'.$data->value;
            Cache::forever($cacheKey, $data);
        }
        return $data;
    }

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
            $logo = $watermark = $autoEmpty = null;
            foreach ($configs as $config) {
                if ($config->key == Config::KEY_LOGO) {
                    $logo = $config;
                } else if ($config->key == Config::KEY_WATERMARK) {
                    $watermark = $config;
                } else if ($config->key == Config::KEY_AUTO_EMPTY) {
                    $autoEmpty = $config;
                }
            }
            $this->updateLogo($data['logo'], $logo);
            $this->updateWatermark($data['watermark'], $watermark);
            $this->updateAutoEmpty($data['auto_empty'], $autoEmpty);
            $this->removeCache();
        });
    }

    protected function updateLogo($data, $logo)
    {
        if ($logo == null) {
            $logo = new Config();
            $logo->key = Config::KEY_LOGO;
            $logo->value = '';
            $logo->save();
        }
        $mlsData = $logo->ml->keyBy('lng_id');

        $mls = [];
        $i = 0;
        foreach ($data as $lngId => $value) {
            $mls[$i] = new ConfigMl(['lng_id' => $lngId]);
            if (isset($mlsData[$lngId])) {
                SaveImage::save($value['image'], $mlsData[$lngId], 'value');
                $mls[$i]->value = $mlsData[$lngId]->value;
            } else {
                SaveImage::save($value['image'], $mls[$i], 'value');
            }
            $i++;
        }
        $logo->ml()->delete();
        $logo->ml()->saveMany($mls);
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

        $languages = Language::all();
        foreach ($languages as $lng) {
            Cache::forget('logo_'.$lng->id);
        }
    }
}