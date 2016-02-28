<?php

namespace App\Models\Cylinder;

class Manager
{
    public function store($data)
    {
        $cylinder = new Cylinder($data);
        $cylinder->show_status = Cylinder::STATUS_ACTIVE;
        $cylinder->save();
        return true;
    }

    public function update($id, $data)
    {
        $cylinder = Cylinder::active()->findOrFail($id);
        $data['show_status'] = Cylinder::STATUS_ACTIVE;
        $cylinder->update($data);
        return true;
    }

    public function delete($id)
    {
        Cylinder::active()->where('id', $id)->update(['show_status' => Cylinder::STATUS_DELETED]);
        return true;
    }
}