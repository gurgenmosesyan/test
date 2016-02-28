<?php

namespace App\Models\Mark;

class Manager
{
    public function store($data)
    {
        $mark = new Mark($data);
        $mark->show_status = Mark::STATUS_ACTIVE;
        $mark->save();
        return true;
    }

    public function update($id, $data)
    {
        $mark = Mark::active()->findOrFail($id);
        $data['show_status'] = Mark::STATUS_ACTIVE;
        $mark->update($data);
        return true;
    }

    public function delete($id)
    {
        Mark::active()->where('id', $id)->update(['show_status' => Mark::STATUS_DELETED]);
        return true;
    }
}