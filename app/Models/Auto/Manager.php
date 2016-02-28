<?php

namespace App\Models\Auto;

use DB;

class Manager
{
    public function store($data)
    {
        $auto = new Auto($data);
        $auto->show_status = Auto::STATUS_ACTIVE;
        DB::transaction(function() use($data, $auto) {
            $auto->save();
            $this->storeMl($data['ml'], $auto);
        });
        return true;
    }

    public function update($id, $data)
    {
        $auto = Auto::active()->findOrFail($id);
        $data['show_status'] = Auto::STATUS_ACTIVE;
        DB::transaction(function() use($data, $auto) {
            $auto->update($data);
            $this->updateMl($data['ml'], $auto);
        });
        return true;
    }

    protected function storeMl($data, Auto $auto)
    {
        $ml = [];
        $i = 0;
        foreach ($data as $lngId => $mlData) {
            $mlData['lng_id'] = $lngId;
            $ml[$i] = new autoMl($mlData);
            $ml[$i]->show_status = Auto::STATUS_ACTIVE;
            $i++;
        }
        $auto->ml()->saveMany($ml);
    }

    protected function updateMl($data, Auto $auto)
    {
        AutoMl::active()->where('id', $auto->id)->update(['show_status' => Auto::STATUS_DELETED]);

        $newMl = [];
        foreach ($data as $lngId => $mlData) {
            $ml = AutoMl::where('id', $auto->id)->where('lng_id', $lngId)->first();
            if ($ml == null) {
                $newMl[$lngId] = $mlData;
            } else {
                $mlData['show_status'] = Auto::STATUS_ACTIVE;
                AutoMl::where('id', $auto->id)->where('lng_id', $lngId)->update($mlData);
            }
        }
        if (!empty($newMl)) {
            $this->storeMl($newMl, $auto);
        }
    }

    public function delete($id)
    {
        DB::transaction(function() use($id) {
            Auto::active()->where('id', $id)->update(['show_status' => Auto::STATUS_DELETED]);
            AutoMl::active()->where('id', $id)->update(['show_status' => Auto::STATUS_DELETED]);
        });
        return true;
    }
}