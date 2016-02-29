<?php

namespace App\Models\Transmission;

use DB;

class Manager
{
    public function store($data)
    {
        $transmission = new Transmission($data);
        $transmission->show_status = Transmission::STATUS_ACTIVE;
        DB::transaction(function() use($data, $transmission) {
            $transmission->save();
            $this->storeMl($data['ml'], $transmission);
        });
        return true;
    }

    public function update($id, $data)
    {
        $transmission = Transmission::active()->findOrFail($id);
        $data['show_status'] = Transmission::STATUS_ACTIVE;
        DB::transaction(function() use($data, $transmission) {
            $transmission->update($data);
            $this->updateMl($data['ml'], $transmission);
        });
        return true;
    }

    protected function storeMl($data, Transmission $transmission)
    {
        $ml = [];
        $i = 0;
        foreach ($data as $lngId => $mlData) {
            $mlData['lng_id'] = $lngId;
            $ml[$i] = new TransmissionMl($mlData);
            $ml[$i]->show_status = Transmission::STATUS_ACTIVE;
            $i++;
        }
        $transmission->ml()->saveMany($ml);
    }

    protected function updateMl($data, Transmission $transmission)
    {
        TransmissionMl::active()->where('id', $transmission->id)->update(['show_status' => Transmission::STATUS_DELETED]);

        $newMl = [];
        foreach ($data as $lngId => $mlData) {
            $ml = TransmissionMl::where('id', $transmission->id)->where('lng_id', $lngId)->first();
            if ($ml == null) {
                $newMl[$lngId] = $mlData;
            } else {
                $mlData['show_status'] = Transmission::STATUS_ACTIVE;
                TransmissionMl::where('id', $transmission->id)->where('lng_id', $lngId)->update($mlData);
            }
        }
        if (!empty($newMl)) {
            $this->storeMl($newMl, $transmission);
        }
    }

    public function delete($id)
    {
        DB::transaction(function() use($id) {
            Transmission::active()->where('id', $id)->update(['show_status' => Transmission::STATUS_DELETED]);
            TransmissionMl::active()->where('id', $id)->update(['show_status' => Transmission::STATUS_DELETED]);
        });
        return true;
    }
}