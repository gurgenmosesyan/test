<?php

namespace App\Models\Model;

use App\Models\ModelCategory\Category;

class Manager
{
    public static function getModelsWithCat($markId, $onlyModel = false)
    {
        $models = Model::active()->where('mark_id', $markId)->orderBy('name', 'asc')->get();
        if ($onlyModel) {
            return $models->toArray();
        }
        $categories = Category::active()->where('mark_id', $markId)->orderBy('name', 'asc')->get();
        if (!$categories->isEmpty()) {
            $data = [];
            $withoutCat = [];
            foreach ($categories as $category) {
                $data[] = [
                    'id' => 'c_'.$category->id,
                    'name' => $category->name
                ];
                foreach ($models as $model) {
                    if ($model->category_id == 0) {
                        $withoutCat[$model->id] = [
                            'id' => $model->id,
                            'name' => $model->name
                        ];
                    } else if ($model->category_id == $category->id) {
                        $data[] = [
                            'id' => $model->id,
                            'name' => '&nbsp;&nbsp;&nbsp;'.$model->name
                        ];
                    }
                }
            }
            return array_merge($data, $withoutCat);
        }
        return $models->toArray();
    }

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
        Model::active()->where('id', $id)->update(['show_status' => Model::STATUS_DELETED]);
        return true;
    }
}