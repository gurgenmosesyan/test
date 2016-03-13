<?php

namespace App\Models\Mark;

use App\Core\Image\SaveImage;

class Manager
{
    public function store($data)
    {
        $mark = new Mark($data);
        SaveImage::save($data['image'], $mark, 'image');
        $mark->show_status = Mark::STATUS_ACTIVE;
        $mark->save();
        return true;
    }

    public function update($id, $data)
    {
        $mark = Mark::active()->findOrFail($id);
        SaveImage::save($data['image'], $mark, 'image');
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