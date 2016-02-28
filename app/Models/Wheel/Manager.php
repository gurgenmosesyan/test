<?php

namespace App\Models\Wheel;

class Manager
{
    public function store($data)
    {
        $wheel = new Wheel($data);
        $wheel->show_status = Wheel::STATUS_ACTIVE;
        $wheel->save();
        return true;
    }

    public function update($id, $data)
    {
        $wheel = Wheel::active()->findOrFail($id);
        $data['show_status'] = Wheel::STATUS_ACTIVE;
        $wheel->update($data);
        return true;
    }

    public function delete($id)
    {
        Wheel::active()->where('id', $id)->update(['show_status' => Wheel::STATUS_DELETED]);
        return true;
    }
}