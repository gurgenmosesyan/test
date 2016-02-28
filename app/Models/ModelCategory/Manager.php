<?php

namespace App\Models\ModelCategory;

class Manager
{
    public function store($data)
    {
        $category = new Category($data);
        $category->show_status = Category::STATUS_ACTIVE;
        $category->save();
        return true;
    }

    public function update($id, $data)
    {
        $category = Category::active()->findOrFail($id);
        $data['show_status'] = Category::STATUS_ACTIVE;
        $category->update($data);
        return true;
    }

    public function delete($id)
    {
        Category::active()->where('id', $id)->update(['show_status' => Category::STATUS_DELETED]);
        return true;
    }
}