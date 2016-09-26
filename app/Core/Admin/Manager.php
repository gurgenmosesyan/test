<?php

namespace App\Core\Admin;

class Manager
{
    public function store($data)
    {
        $data = $this->processSave($data);
        $admin = new Admin($data);
        $admin->password = bcrypt($data['password']);
        $admin->super_admin = Admin::NOT_SUPER_ADMIN;
        return $admin->save();
    }

    public function update($id, $data)
    {
        $admin = Admin::findOrFail($id);
        $data = $this->processSave($data);
        if (!empty($data['password'])) {
            $admin->password = bcrypt($data['password']);
        }
        return $admin->update($data);
    }

    protected function processSave($data)
    {
        if (!isset($data['permissions'])) {
            $data['permissions'] = [];
        }
        $data['permissions'] = json_encode($data['permissions']);

        return $data;
    }

    public function delete($id)
    {
        Admin::where('id', $id)->delete();
        return true;
    }
}