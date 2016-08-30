<?php

namespace App\Models\Auto;

use App\Core\Image\SaveImage;
use Intervention\Image\ImageManagerStatic as ImageManager;
use App\Models\Config\Config;
use DB;
use Auth;

class Manager
{
    public function store($data)
    {
        $data = $this->processSave($data);
        $auto = new Auto($data);
	    $auto->auto_id = $this->generateUniqueAutoId();
        $auto->term = date('Y-m-d', time()+(60*60*24*7*$data['term']));
        $auto->show_status = Auto::STATUS_ACTIVE;
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
        //$data['show_status'] = Auto::STATUS_ACTIVE;
        $data['term'] = empty($data['term']) ? $auto->term : date('Y-m-d', time()+(60*60*24*7*$data['term']));
        $data = $this->processSave($data);
        DB::transaction(function() use($data, $auto) {
            $auto->update($data);
            $this->updateOptions($data['options'], $auto, true);
            $this->updateImages($data['images'], $auto);
        });
        return true;
    }

	protected function generateUniqueAutoId()
	{
		$autoId = str_random(11);
		$auto = Auto::active()->where('auto_id', $autoId)->first();
		if ($auto == null) {
			return $autoId;
		}
		return $this->generateUniqueAutoId();
	}

    protected function processSave($data)
    {
        if ($data['mileage_measurement'] == Auto::MILEAGE_MEASUREMENT_KM) {
            $data['mileage_km'] = $data['mileage'];
            $data['mileage_mile'] = round($data['mileage'] / 1.60934);
        } else {
            $data['mileage_mile'] = $data['mileage'];
            $data['mileage_km'] = round($data['mileage'] * 1.60934);
        }
        if (!isset($data['contract'])) {
            $data['contract'] = AUTO::NOT_CONTRACT;
        }
        if (!isset($data['auction'])) {
            $data['auction'] = AUTO::NOT_AUCTION;
        }
        if (!isset($data['bank'])) {
            $data['bank'] = AUTO::NOT_BANK;
        }
        if (!isset($data['exchange'])) {
            $data['exchange'] = AUTO::NOT_EXCHANGE;
        }
        if (!isset($data['partial_pay'])) {
            $data['partial_pay'] = AUTO::NOT_PARTIAL_PAY;
        }
        if (!isset($data['custom_cleared'])) {
            $data['custom_cleared'] = AUTO::NOT_CUSTOM_CLEARED;
        }
        if (!isset($data['damaged'])) {
            $data['damaged'] = AUTO::NOT_DAMAGED;
        }
        if (!isset($data['options'])) {
            $data['options'] = [];
        }
        if (!isset($data['images'])) {
            $data['images'] = [];
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

    protected function storeImages($data, Auto $auto, $setMain = true)
    {
        $watermark = Config::where('key', Config::KEY_WATERMARK)->first();
        $images = [];
        $i = 0;
        foreach ($data as $value) {
            $images[$i] = new AutoImage(['show_status' => Auto::STATUS_ACTIVE]);
            $fileName = SaveImage::save($value['image'], $images[$i]);
            $images[$i]->save();

            $filePath = public_path($images[$i]->getStorePath().'/'.$fileName);
            $image = ImageManager::make($filePath);
            $width = $image->width();
            $height = $image->height();
            if ($width > $height && $width > 1200) {
                $image->resize(1200, null, function($constraint) {
                    $constraint->aspectRatio();
                });
            } else if ($height > 1200) {
                $image->resize(null, 1200, function($constraint) {
                    $constraint->aspectRatio();
                });
            }
            if (!empty($value['rotate'])) {
                $image->rotate($value['rotate']);
            }
            if ($watermark != null) {
                $image->insert(public_path(Config::IMAGES_PATH.'/'.$watermark->value), 'bottom-right', 15, 10);
            }
            $image->save($filePath);

            /*$image = new Image($filePath);
            if (!empty($value['rotate'])) {
                $image->rotate($value['rotate']);
            }
            $watermark = imagecreatefrompng(public_path('images/watermark.png'));
            imagealphablending($watermark, false);
            imagesavealpha($watermark, true);
            $image->watermarkImage($watermark, 10);
            $image->save($filePath);*/

            $i++;
        }
        if (!empty($images)) {
            $auto->images()->saveMany($images);
            if ($setMain) {
                $auto->image = $images[0]->image;
                $auto->save();
            }
        }
    }

    protected function updateImages($data, Auto $auto)
    {
        AutoImage::where('auto_id', $auto->id)->update(['show_status' => Auto::STATUS_DELETED]);
        $newImages = [];
        $setMain = false;
        $i = 0;
        foreach ($data as $value) {
            if (empty($value['id'])) {
                $newImages[] = $value;
                $setMain = $i == 0 ? true : false;
            } else {
                $autoImage = AutoImage::findOrFail($value['id']);
                if (!empty($value['rotate'])) {
                    $filePath = public_path($autoImage->getStorePath().'/'.$autoImage->image);
                    $image = ImageManager::make($filePath);
                    $image->rotate($value['rotate']);
                    list($newFilePath, $subDir, $fileName) = SaveImage::createPathInfo($autoImage, pathinfo($filePath, PATHINFO_EXTENSION));
                    $image->save($newFilePath.'/'.$subDir.'/'.$fileName);
                    $autoImage->setFile($subDir.'/'.$fileName, 'image');
                    unlink($filePath);

                    /*$image = new Image($filePath);
                    $image->rotate($value['rotate']);
                    list($newFilePath, $subDir, $fileName) = SaveImage::createPathInfo($autoImage, pathinfo($filePath, PATHINFO_EXTENSION));
                    $image->save($newFilePath.'/'.$subDir.'/'.$fileName);
                    $autoImage->setFile($subDir.'/'.$fileName, 'image');
                    unlink($filePath);*/
                }
                $autoImage->show_status = Auto::STATUS_ACTIVE;
                $autoImage->save();
                if ($i == 0) {
                    $auto->image = $autoImage->image;
                    $auto->save();
                }
            }
            $i++;
        }
        if (!empty($newImages)) {
            $this->storeImages($newImages, $auto, $setMain);
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

    /************************** User **************************/

    public function add($data)
    {
        $data = $this->processSave($data);
        $auto = new Auto($data);
        $auto->auto_id = $this->generateUniqueAutoId();
        $auto->user_id = Auth::guard('user')->user()->id;
        $auto->term = date('Y-m-d', time()+(60*60*24*7*$data['term']));
        $auto->status = Auto::STATUS_PENDING;
        $auto->show_status = Auto::STATUS_ACTIVE;

        DB::transaction(function() use($data, $auto) {
            $auto->save();
            $this->updateOptions($data['options'], $auto);
            $this->storeImages($data['images'], $auto);
        });
    }

    public function updateAuto($data, $id)
    {
        $user = Auth::guard('user')->user();
        $auto = Auto::active()->where('user_id', $user->id)->where('id', $id)->firstOrFail();
        $data['user_id'] = $user->id;
        $data['term'] = empty($data['term']) ? $auto->term : date('Y-m-d', time()+(60*60*24*7*$data['term']));
        $data = $this->processSave($data);
        DB::transaction(function() use($data, $auto) {
            $auto->update($data);
            $this->updateOptions($data['options'], $auto, true);
            $this->updateImages($data['images'], $auto);
        });
        return true;
    }
}