<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ModelCategory\Category;
use App\Models\Model\Model;
use App\Models\Part\Part;

class ApiController extends Controller
{
    public function model(Request $request)
    {
        $markId = $request->input('mark_id');
        $onlyModel = $request->input('only_model');

        $models = Model::active()->where('mark_id', $markId)->orderBy('name', 'asc')->get();
        if ($onlyModel) {
            return $this->api('OK', $models);
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
            $data = array_merge($data, $withoutCat);
            return $this->api('OK', $data);
        }
        return $this->api('OK', $models);
    }

    public function part(Request $request)
    {
        $markId = $request->input('mark_id');
        $modelId = $request->input('model_id');

        $part = Part::where('mark_id', $markId)->where('model_id', $modelId)->first();
        $part = view('blocks.part')->with(['part' => $part])->render();
        return $this->api('OK', $part);
    }
}