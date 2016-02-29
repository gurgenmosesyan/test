<?php

namespace App\Models\Region;

use DB;

class Manager
{
    public function store($data)
    {
        $region = new Region($data);
        $region->show_status = Region::STATUS_ACTIVE;
        DB::transaction(function() use($data, $region) {
            $region->save();
            $this->storeMl($data['ml'], $region);
        });
        return true;
    }

    public function update($id, $data)
    {
        $region = Region::active()->findOrFail($id);
        DB::transaction(function() use($data, $region) {
            $region->update($data);
            $this->updateMl($data['ml'], $region);
        });
        return true;
    }

    protected function storeMl($data, Region $region)
    {
        $ml = [];
        $i = 0;
        foreach ($data as $lngId => $mlData) {
            $mlData['lng_id'] = $lngId;
            $ml[$i] = new RegionMl($mlData);
            $ml[$i]->show_status = Region::STATUS_ACTIVE;
            $i++;
        }
        $region->ml()->saveMany($ml);
    }

    protected function updateMl($data, Region $region)
    {
        RegionMl::active()->where('id', $region->id)->update(['show_status' => Region::STATUS_DELETED]);

        $newMl = [];
        foreach ($data as $lngId => $mlData) {
            $ml = RegionMl::where('id', $region->id)->where('lng_id', $lngId)->first();
            if ($ml == null) {
                $newMl[$lngId] = $mlData;
            } else {
                $mlData['show_status'] = Region::STATUS_ACTIVE;
                RegionMl::where('id', $region->id)->where('lng_id', $lngId)->update($mlData);
            }
        }
        if (!empty($newMl)) {
            $this->storeMl($newMl, $region);
        }
    }

    public function delete($id)
    {
        DB::transaction(function() use($id) {
            Region::active()->where('id', $id)->update(['show_status' => Region::STATUS_DELETED]);
            RegionMl::active()->where('id', $id)->update(['show_status' => Region::STATUS_DELETED]);
        });
        return true;
    }
}