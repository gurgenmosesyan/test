<?php

namespace App\Models\Ad;

use App\Core\Image\SaveImage;
use Cache;
use DB;

class Manager
{
    public static function get($key)
    {
        $cacheKey = 'ad_'.$key;
        $data = Cache::get($cacheKey);
        if ($data == null) {
            $data = Ad::active()->where('key', $key)->get();
            Cache::forever($cacheKey, $data);
        }
        return $data->shuffle();
    }

    public function store($data)
    {
        $ad = new Ad($data);
        SaveImage::save($data['image'], $ad);
        $ad->user_id = 0;
        $ad->show_status = Ad::STATUS_ACTIVE;
        DB::transaction(function() use($ad) {
            $ad->save();
            $this->removeCache($ad->key);
        });
    }

    public function update($id, $data)
    {
        $ad = Ad::active()->findOrFail($id);
        SaveImage::save($data['image'], $ad);
        $data['user_id'] = 0;
        $data['show_status'] = Ad::STATUS_ACTIVE;
        DB::transaction(function() use($ad, $data) {
            $this->removeCache($ad->key);
            $ad->update($data);
            $this->removeCache($ad->key);
        });
    }

    public function delete($id)
    {
        DB::transaction(function() use($id) {
            $ad = Ad::active()->where('id', $id)->first();
            Ad::active()->where('id', $id)->update(['show_status' => Ad::STATUS_DELETED]);
            if ($ad != null) {
                $this->removeCache($ad->key);
            }
        });
    }

    protected function removeCache($key)
    {
        Cache::forget('ad_'.$key);
    }
}