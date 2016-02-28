<?php

namespace App\Models\Rudder;

use DB;

class Manager
{
    public function store($data)
    {
        $rudder = new Rudder($data);
        $rudder->show_status = Rudder::STATUS_ACTIVE;
        DB::transaction(function() use($data, $rudder) {
            $rudder->save();
            $this->storeMl($data['ml'], $rudder);
        });
        return true;
    }

    public function update($id, $data)
    {
        $rudder = Rudder::active()->findOrFail($id);
        $data['show_status'] = Rudder::STATUS_ACTIVE;
        DB::transaction(function() use($data, $rudder) {
            $rudder->update($data);
            $this->updateMl($data['ml'], $rudder);
        });
        return true;
    }

    protected function storeMl($data, Rudder $rudder)
    {
        $ml = [];
        $i = 0;
        foreach ($data as $lngId => $mlData) {
            $mlData['lng_id'] = $lngId;
            $ml[$i] = new rudderMl($mlData);
            $ml[$i]->show_status = Rudder::STATUS_ACTIVE;
            $i++;
        }
        $rudder->ml()->saveMany($ml);
    }

    protected function updateMl($data, Rudder $rudder)
    {
        RudderMl::active()->where('id', $rudder->id)->update(['show_status' => Rudder::STATUS_DELETED]);

        $newMl = [];
        foreach ($data as $lngId => $mlData) {
            $ml = RudderMl::where('id', $rudder->id)->where('lng_id', $lngId)->first();
            if ($ml == null) {
                $newMl[$lngId] = $mlData;
            } else {
                $mlData['show_status'] = Rudder::STATUS_ACTIVE;
                RudderMl::where('id', $rudder->id)->where('lng_id', $lngId)->update($mlData);
            }
        }
        if (!empty($newMl)) {
            $this->storeMl($newMl, $rudder);
        }
    }

    public function delete($id)
    {
        DB::transaction(function() use($id) {
            Rudder::active()->where('id', $id)->update(['show_status' => Rudder::STATUS_DELETED]);
            RudderMl::active()->where('id', $id)->update(['show_status' => Rudder::STATUS_DELETED]);
        });
        return true;
    }
}