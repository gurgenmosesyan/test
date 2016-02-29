<?php

namespace App\Models\Train;

use DB;

class Manager
{
    public function store($data)
    {
        $train = new Train($data);
        $train->show_status = Train::STATUS_ACTIVE;
        DB::transaction(function() use($data, $train) {
            $train->save();
            $this->storeMl($data['ml'], $train);
        });
        return true;
    }

    public function update($id, $data)
    {
        $train = Train::active()->findOrFail($id);
        $data['show_status'] = Train::STATUS_ACTIVE;
        DB::transaction(function() use($data, $train) {
            $train->update($data);
            $this->updateMl($data['ml'], $train);
        });
        return true;
    }

    protected function storeMl($data, Train $train)
    {
        $ml = [];
        $i = 0;
        foreach ($data as $lngId => $mlData) {
            $mlData['lng_id'] = $lngId;
            $ml[$i] = new TrainMl($mlData);
            $ml[$i]->show_status = Train::STATUS_ACTIVE;
            $i++;
        }
        $train->ml()->saveMany($ml);
    }

    protected function updateMl($data, Train $train)
    {
        TrainMl::active()->where('id', $train->id)->update(['show_status' => Train::STATUS_DELETED]);

        $newMl = [];
        foreach ($data as $lngId => $mlData) {
            $ml = TrainMl::where('id', $train->id)->where('lng_id', $lngId)->first();
            if ($ml == null) {
                $newMl[$lngId] = $mlData;
            } else {
                $mlData['show_status'] = Train::STATUS_ACTIVE;
                TrainMl::where('id', $train->id)->where('lng_id', $lngId)->update($mlData);
            }
        }
        if (!empty($newMl)) {
            $this->storeMl($newMl, $train);
        }
    }

    public function delete($id)
    {
        DB::transaction(function() use($id) {
            Train::active()->where('id', $id)->update(['show_status' => Train::STATUS_DELETED]);
            TrainMl::active()->where('id', $id)->update(['show_status' => Train::STATUS_DELETED]);
        });
        return true;
    }
}