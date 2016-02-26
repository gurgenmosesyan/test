<?php

namespace App\Models\Admin;

class Manager
{
    public function store($data)
    {
        $admin = new Admin($data);
        $admin->password = bcrypt($data['password']);
        return $admin->save();
    }

    public function update($id, $data)
    {
        $admin = Admin::findOrFail($id);
        if (!empty($data['password'])) {
            $admin->password = bcrypt($data['password']);
        }
        return $admin->update($data);
    }

    public function delete($id)
    {
        Admin::find($id)->delete();
        return true;
    }
}