<?php

namespace App\Models\Mark;

use DB;

class Manager
{
    public function store($data)
    {
        $mark = new Mark($data);
        DB::transaction(function() use($data, $mark) {
            $mark->save();
            $this->storeMl($data['ml'], $mark);
        });
        return true;
    }

    public function update($id, $data)
    {
        $mark = Mark::active()->firstOrFail($id);
        DB::transaction(function() use($data, $mark) {
            $mark->update($data);
            $this->updateMl($data, $mark);
        });
        return true;
    }

    protected function storeMl($data, Mark $mark)
    {

    }

    public function delete($id)
    {
        Mark::find($id)->delete();
        return true;
    }
}