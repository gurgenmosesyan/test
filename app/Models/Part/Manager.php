<?php

namespace App\Models\Part;

class Manager
{
    public function store($data)
    {
        $part = new Part($data);
        $part->save();
        return true;
    }

    public function update($id, $data)
    {
        $part = Part::findOrFail($id);
        $part->update($data);
        return true;
    }

    public function delete($id)
    {
        Part::where('id', $id)->delete();
        return true;
    }
}