<?php

namespace App\Models\Engine;

use DB;

class Manager
{
    public function store($data)
    {
        $engine = new Engine($data);
        $engine->show_status = Engine::STATUS_ACTIVE;
        DB::transaction(function() use($data, $engine) {
            $engine->save();
            $this->storeMl($data['ml'], $engine);
        });
        return true;
    }

    public function update($id, $data)
    {
        $engine = Engine::active()->findOrFail($id);
        $data['show_status'] = Engine::STATUS_ACTIVE;
        DB::transaction(function() use($data, $engine) {
            $engine->update($data);
            $this->updateMl($data['ml'], $engine);
        });
        return true;
    }

    protected function storeMl($data, Engine $engine)
    {
        $ml = [];
        $i = 0;
        foreach ($data as $lngId => $mlData) {
            $mlData['lng_id'] = $lngId;
            $ml[$i] = new EngineMl($mlData);
            $ml[$i]->show_status = Engine::STATUS_ACTIVE;
            $i++;
        }
        $engine->ml()->saveMany($ml);
    }

    protected function updateMl($data, Engine $engine)
    {
        EngineMl::active()->where('id', $engine->id)->update(['show_status' => Engine::STATUS_DELETED]);

        $newMl = [];
        foreach ($data as $lngId => $mlData) {
            $ml = EngineMl::where('id', $engine->id)->where('lng_id', $lngId)->first();
            if ($ml == null) {
                $newMl[$lngId] = $mlData;
            } else {
                $mlData['show_status'] = Engine::STATUS_ACTIVE;
                EngineMl::where('id', $engine->id)->where('lng_id', $lngId)->update($mlData);
            }
        }
        if (!empty($newMl)) {
            $this->storeMl($newMl, $engine);
        }
    }

    public function delete($id)
    {
        DB::transaction(function() use($id) {
            Engine::active()->where('id', $id)->update(['show_status' => Engine::STATUS_DELETED]);
            EngineMl::active()->where('id', $id)->update(['show_status' => Engine::STATUS_DELETED]);
        });
        return true;
    }
}