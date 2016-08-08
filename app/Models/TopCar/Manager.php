<?php

namespace App\Models\TopCar;

use DB;

class Manager
{
    public function store($data)
    {
        $topCar = new TopCar($data);
        $topCar->user_id = 0;
        $topCar->show_status = TopCar::STATUS_ACTIVE;
        $topCar->save();
    }

    public function update($id, $data)
    {
        $topCar = TopCar::active()->findOrFail($id);
        $data['user_id'] = 0;
        $data['show_status'] = TopCar::STATUS_ACTIVE;
        $topCar->update($data);
    }

    public function delete($id)
    {
        TopCar::active()->where('id', $id)->update(['show_status' => TopCar::STATUS_DELETED]);
    }
}