<?php

namespace App\Models\Color;

use DB;

class Manager
{
    public function store($data)
    {
        $color = new Color($data);
        $color->show_status = Color::STATUS_ACTIVE;
        DB::transaction(function() use($data, $color) {
            $color->save();
            $this->storeMl($data['ml'], $color);
        });
        return true;
    }

    public function update($id, $data)
    {
        $color = Color::active()->findOrFail($id);
        $data['show_status'] = Color::STATUS_ACTIVE;
        DB::transaction(function() use($data, $color) {
            $color->update($data);
            $this->updateMl($data['ml'], $color);
        });
        return true;
    }

    protected function storeMl($data, Color $color)
    {
        $ml = [];
        $i = 0;
        foreach ($data as $lngId => $mlData) {
            $mlData['lng_id'] = $lngId;
            $ml[$i] = new ColorMl($mlData);
            $ml[$i]->show_status = Color::STATUS_ACTIVE;
            $i++;
        }
        $color->ml()->saveMany($ml);
    }

    protected function updateMl($data, Color $color)
    {
        ColorMl::active()->where('id', $color->id)->update(['show_status' => Color::STATUS_DELETED]);

        $newMl = [];
        foreach ($data as $lngId => $mlData) {
            $ml = ColorMl::where('id', $color->id)->where('lng_id', $lngId)->first();
            if ($ml == null) {
                $newMl[$lngId] = $mlData;
            } else {
                $mlData['show_status'] = Color::STATUS_ACTIVE;
                ColorMl::where('id', $color->id)->where('lng_id', $lngId)->update($mlData);
            }
        }
        if (!empty($newMl)) {
            $this->storeMl($newMl, $color);
        }
    }

    public function delete($id)
    {
        DB::transaction(function() use($id) {
            Color::active()->where('id', $id)->update(['show_status' => Color::STATUS_DELETED]);
            ColorMl::active()->where('id', $id)->update(['show_status' => Color::STATUS_DELETED]);
        });
        return true;
    }
}