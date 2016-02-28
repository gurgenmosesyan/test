<?php

namespace App\Models\Option;

use DB;

class Manager
{
    public function store($data)
    {
        $option = new Option($data);
        $option->show_status = Option::STATUS_ACTIVE;
        DB::transaction(function() use($data, $option) {
            $option->save();
            $this->storeMl($data['ml'], $option);
        });
        return true;
    }

    public function update($id, $data)
    {
        $option = Option::active()->findOrFail($id);
        $data['show_status'] = Option::STATUS_ACTIVE;
        DB::transaction(function() use($data, $option) {
            $option->update($data);
            $this->updateMl($data['ml'], $option);
        });
        return true;
    }

    protected function storeMl($data, Option $option)
    {
        $ml = [];
        $i = 0;
        foreach ($data as $lngId => $mlData) {
            $mlData['lng_id'] = $lngId;
            $ml[$i] = new optionMl($mlData);
            $ml[$i]->show_status = Option::STATUS_ACTIVE;
            $i++;
        }
        $option->ml()->saveMany($ml);
    }

    protected function updateMl($data, Option $option)
    {
        OptionMl::active()->where('id', $option->id)->update(['show_status' => Option::STATUS_DELETED]);

        $newMl = [];
        foreach ($data as $lngId => $mlData) {
            $ml = OptionMl::where('id', $option->id)->where('lng_id', $lngId)->first();
            if ($ml == null) {
                $newMl[$lngId] = $mlData;
            } else {
                $mlData['show_status'] = Option::STATUS_ACTIVE;
                OptionMl::where('id', $option->id)->where('lng_id', $lngId)->update($mlData);
            }
        }
        if (!empty($newMl)) {
            $this->storeMl($newMl, $option);
        }
    }

    public function delete($id)
    {
        DB::transaction(function() use($id) {
            Option::active()->where('id', $id)->update(['show_status' => Option::STATUS_DELETED]);
            OptionMl::active()->where('id', $id)->update(['show_status' => Option::STATUS_DELETED]);
        });
        return true;
    }
}