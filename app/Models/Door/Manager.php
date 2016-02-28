<?php

namespace App\Models\Door;

class Manager
{
    public function store($data)
    {
        $door = new Door($data);
        $door->show_status = Door::STATUS_ACTIVE;
        $door->save();
        return true;
    }

    public function update($id, $data)
    {
        $door = Door::active()->findOrFail($id);
        $data['show_status'] = Door::STATUS_ACTIVE;
        $door->update($data);
        return true;
    }

    public function delete($id)
    {
        Door::active()->where('id', $id)->update(['show_status' => Door::STATUS_DELETED]);
        return true;
    }
}