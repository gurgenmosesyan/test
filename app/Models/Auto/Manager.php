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
        });
        return true;
    }

    public function update($id, $data)
    {
        $auto = Auto::active()->findOrFail($id);
        $data['show_status'] = Auto::STATUS_ACTIVE;
        DB::transaction(function() use($data, $auto) {
            $auto->update($data);
        });
        return true;
    }

    public function delete($id)
    {
        DB::transaction(function() use($id) {
            Auto::active()->where('id', $id)->update(['show_status' => Auto::STATUS_DELETED]);
        });
        return true;
    }
}