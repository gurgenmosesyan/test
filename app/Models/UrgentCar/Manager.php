<?php

namespace App\Models\UrgentCar;

use DB;

class Manager
{
    public function store($data)
    {
        $urgentCar = new UrgentCar($data);
        $urgentCar->user_id = 0;
        $urgentCar->show_status = UrgentCar::STATUS_ACTIVE;
        $urgentCar->save();
    }

    public function update($id, $data)
    {
        $urgentCar = UrgentCar::active()->findOrFail($id);
        $data['user_id'] = 0;
        $data['show_status'] = UrgentCar::STATUS_ACTIVE;
        $urgentCar->update($data);
    }

    public function delete($id)
    {
        UrgentCar::active()->where('id', $id)->update(['show_status' => UrgentCar::STATUS_DELETED]);
    }
}