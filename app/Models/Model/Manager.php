<?php

namespace App\Models\Model;

class Manager
{
    public function store($data)
    {
        $model = new Model($data);
        $model->show_status = Model::STATUS_ACTIVE;
        $model->save();
        return true;
    }

    public function update($id, $data)
    {
        $model = Model::active()->findOrFail($id);
        $data['show_status'] = Model::STATUS_ACTIVE;
        $model->update($data);
        return true;
    }

    public function delete($id)
    {
        Model::find($id)->update(['show_status' => Model::STATUS_DELETED]);
        return true;
    }
}