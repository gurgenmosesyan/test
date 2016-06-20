<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ModelCategory\Category;
use App\Models\Model\Model;

class ApiController extends Controller
{
    public function model(Request $request)
    {
        $markId = $request->input('mark_id');

        $categories = Category::active()->where('mark_id', $markId)->orderBy('name', 'asc')->get();
        $models = Model::active()->where('mark_id', $markId)->orderBy('name', 'asc')->get();

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
            $data = array_merge($data, $withoutCat);
            return $this->api('OK', $data);
        }
        return $this->api('OK', $models);
    }
}