<?php

namespace App\Models\Auto;

use App\Core\Image\Image;
use App\Core\Image\SaveImage;
use DB;

class Manager
{
    public function store($data)
    {
        $auto = new Auto($data);
        $auto->user_id = 1; // FIXME
        $auto->show_status = Auto::STATUS_ACTIVE;
        $data = $this->processSave($data);
        DB::transaction(function() use($data, $auto) {
            $auto->save();
            $this->updateOptions($data['options'], $auto);
            $this->storeImages($data['images'], $auto);
        });
        return true;
    }

    public function update($id, $data)
    {
        $auto = Auto::active()->findOrFail($id);
        $data['user_id'] = 1; // FIXME
        $data['show_status'] = Auto::STATUS_ACTIVE;
        $data = $this->processSave($data);
        DB::transaction(function() use($data, $auto) {
            $auto->update($data);
            $this->updateOptions($data['options'], $auto, true);
            $this->updateImages($data['images'], $auto);
        });
        return true;
    }

    protected function processSave($data)
    {
        if (!isset($data['options'])) {
            $data['options'] = [];
        }
        return $data;
    }

    protected function updateOptions($options, Auto $auto, $editMode = true)
    {
        if ($editMode === true) {
            AutoOption::where('auto_id', $auto->id)->delete();
        }
        if (!empty($options)) {
            $autoOptions = [];
            foreach ($options as $optionId) {
                $autoOptions[] = new AutoOption(['option_id' => $optionId]);
            }
            $auto->options()->saveMany($autoOptions);
        }
    }

    protected function storeImages($data, Auto $auto)
    {
        $images = [];
        $i = 0;
        foreach ($data as $value) {
            $images[$i] = new AutoImage(['show_status' => Auto::STATUS_ACTIVE]);
            $fileName = SaveImage::save($value['image'], $images[$i]);
            $images[$i]->save();
            if (!empty($value['rotate'])) {
                $filePath = public_path($images[$i]->getStorePath().'/'.$fileName);
                $image = new Image($filePath);
                $image->rotate($value['rotate']);
                $image->save($filePath);
            }
            $i++;
        }
        if (!empty($images)) {
            $auto->images()->saveMany($images);
        }
    }

    protected function updateImages($data, Auto $auto)
    {
        AutoImage::where('auto_id', $auto->id)->update(['show_status' => Auto::STATUS_DELETED]);
        $newImages = [];
        foreach ($data as $value) {
            if (empty($value['id'])) {
                $newImages[] = $value;
            } else {
                $autoImage = AutoImage::findOrFail($value['id']);
                if (!empty($value['rotate'])) {
                    $filePath = public_path($autoImage->getStorePath().'/'.$autoImage->image);
                    $image = new Image($filePath);
                    $image->rotate($value['rotate']);
                    list($newFilePath, $subDir, $fileName) = SaveImage::createPathInfo($autoImage, pathinfo($filePath, PATHINFO_EXTENSION));
                    $image->save($newFilePath.'/'.$subDir.'/'.$fileName);
                    $autoImage->setFile($subDir.'/'.$fileName, 'image');
                    unlink($filePath);
                }
                $autoImage->show_status = Auto::STATUS_ACTIVE;
                $autoImage->save();
            }
        }
        if (!empty($newImages)) {
            $this->storeImages($newImages, $auto);
        }
        $deletedImages = AutoImage::where('auto_id', $auto->id)->where('show_status', Auto::STATUS_DELETED)->get();
        foreach ($deletedImages as $deletedImage) {
            $imgPath = public_path($deletedImage->getStorePath().'/'.$deletedImage->image);
            if (file_exists($imgPath)) {
                unlink($imgPath);
            }
        }
        AutoImage::where('auto_id', $auto->id)->where('show_status', Auto::STATUS_DELETED)->delete();
    }

    public function delete($id)
    {
        Auto::active()->where('id', $id)->update(['show_status' => Auto::STATUS_DELETED]);
        return true;
    }
}