<?php

namespace App\Models\Tax;

class Manager
{
    public function store($data)
    {
        $tax = new Tax($data);
        $tax->save();
    }

    public function update($id, $data)
    {
        $tax = Tax::active()->findOrFail($id);
        $tax->update($data);
    }

    public function delete($id)
    {
        Tax::where('id', $id)->delete();
    }
}