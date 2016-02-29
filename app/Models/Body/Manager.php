<?php

namespace App\Models\Body;

use DB;

class Manager
{
    public function store($data)
    {
        $body = new Body($data);
        $body->show_status = Body::STATUS_ACTIVE;
        DB::transaction(function() use($data, $body) {
            $body->save();
            $this->storeMl($data['ml'], $body);
        });
        return true;
    }

    public function update($id, $data)
    {
        $body = Body::active()->findOrFail($id);
        $data['show_status'] = Body::STATUS_ACTIVE;
        DB::transaction(function() use($data, $body) {
            $body->update($data);
            $this->updateMl($data['ml'], $body);
        });
        return true;
    }

    protected function storeMl($data, Body $body)
    {
        $ml = [];
        $i = 0;
        foreach ($data as $lngId => $mlData) {
            $mlData['lng_id'] = $lngId;
            $ml[$i] = new BodyMl($mlData);
            $ml[$i]->show_status = Body::STATUS_ACTIVE;
            $i++;
        }
        $body->ml()->saveMany($ml);
    }

    protected function updateMl($data, Body $body)
    {
        BodyMl::active()->where('id', $body->id)->update(['show_status' => Body::STATUS_DELETED]);

        $newMl = [];
        foreach ($data as $lngId => $mlData) {
            $ml = BodyMl::where('id', $body->id)->where('lng_id', $lngId)->first();
            if ($ml == null) {
                $newMl[$lngId] = $mlData;
            } else {
                $mlData['show_status'] = Body::STATUS_ACTIVE;
                BodyMl::where('id', $body->id)->where('lng_id', $lngId)->update($mlData);
            }
        }
        if (!empty($newMl)) {
            $this->storeMl($newMl, $body);
        }
    }

    public function delete($id)
    {
        DB::transaction(function() use($id) {
            Body::active()->where('id', $id)->update(['show_status' => Body::STATUS_DELETED]);
            BodyMl::active()->where('id', $id)->update(['show_status' => Body::STATUS_DELETED]);
        });
        return true;
    }
}