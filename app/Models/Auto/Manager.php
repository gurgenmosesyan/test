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
            $data['contract'] = Auto::NOT_CONTRACT;
        } else if ($data['contract'] == Auto::CONTRACT) {
            $data['price'] = 0;
        }
        if (!isset($data['auction'])) {
            $data['auction'] = Auto::NOT_AUCTION;
        } else if ($data['auction'] == Auto::AUCTION) {
            $data['price'] = 0;
        }
        if (!isset($data['bank'])) {
            $data['bank'] = Auto::NOT_BANK;
        }
        if (!isset($data['exchange'])) {
            $data['exchange'] = Auto::NOT_EXCHANGE;
        }
        if (!isset($data['partial_pay'])) {
            $data['partial_pay'] = Auto::NOT_PARTIAL_PAY;
        }
        if (!isset($data['custom_cleared'])) {
            $data['custom_cleared'] = Auto::NOT_CUSTOM_CLEARED;
        }
        if (!isset($data['damaged'])) {
            $data['damaged'] = Auto::NOT_DAMAGED;
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
        $defImgKey = null;
        foreach ($data as $value) {
            $images[$i] = new AutoImage(['show_status' => Auto::STATUS_ACTIVE]);
            $fileName = SaveImage::save($value['image'], $images[$i]);
            $images[$i]->save();

            $filePath = public_path($images[$i]->getStorePath().'/'.$fileName);
            $image = ImageManager::make($filePath);
            if (!empty($value['rotate'])) {
                $image->rotate($value['rotate']);
            }
            $this->processImage($image);
            if ($watermark != null) {
                $image->insert(public_path(Config::IMAGES_PATH.'/'.$watermark->value), 'bottom-right', 15, 10);
            }
            $image->save($filePath);

            if (isset($value['default']) && $value['default'] == Auto::IMAGE_DEFAULT) {
                $defImgKey = $i;
            }
            $i++;
        }
        if (!empty($images)) {
            $auto->images()->saveMany($images);
            if ($defImgKey !== null) {
                $auto->image = $images[$defImgKey]->image;
                $auto->save();
            } else if ($setMain) {
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
        $defImg = null;
        $i = 0;
        foreach ($data as $value) {
            if (empty($value['id'])) {
                $newImages[] = $value;
                if ($i == 0) {
                    $setMain = true;
                }
            } else {
                $autoImage = AutoImage::findOrFail($value['id']);
                if (!empty($value['rotate'])) {
                    $filePath = public_path($autoImage->getStorePath().'/'.$autoImage->image);
                    $image = ImageManager::make($filePath);
                    $image->rotate($value['rotate']);
                    $this->processImage($image);
                    list($newFilePath, $subDir, $fileName) = SaveImage::createPathInfo($autoImage, pathinfo($filePath, PATHINFO_EXTENSION));
                    $image->save($newFilePath.'/'.$subDir.'/'.$fileName);
                    $autoImage->setFile($subDir.'/'.$fileName, 'image');
                    unlink($filePath);
                }
                $autoImage->show_status = Auto::STATUS_ACTIVE;
                $autoImage->save();
                if ($i == 0 || (isset($value['default']) && $value['default'] == Auto::IMAGE_DEFAULT)) {
                    $defImg = $autoImage;
                }
            }
            $i++;
        }
        if (empty($data)) {
            $auto->image = '';
            $auto->save();
        } else if ($defImg !== null) {
            $auto->image = $defImg->image;
            $auto->save();
        }
        if (!empty($newImages)) {
            $this->storeImages($newImages, $auto, $setMain);
        }
        $deletedImages = AutoImage::where('auto_id', $auto->id)->where('show_status', Auto::STATUS_DELETED)->get();
        foreach ($deletedImages as $deletedImage) {
            $imgPath = public_path($deletedImage->getStorePath().'/'.$deletedImage->image);
            if (file_exists($imgPath)) {
                unlink($imgPath);
                $pathInfo = pathinfo($imgPath);
                SaveImage::deleteFolder($pathInfo['dirname'] . '/' . $pathInfo['filename']);
            }
        }
        AutoImage::where('auto_id', $auto->id)->where('show_status', Auto::STATUS_DELETED)->delete();
    }

    protected function processImage($image)
    {
        $width = $image->width();
        $height = $image->height();

        $w = 1200;
        $h = 900;
        if (($width / $height) > ($w / $h)) {
            $image->resize(null, $h, function($constraint) {
                $constraint->aspectRatio();
            });
            $width = $image->getWidth();
            $x = abs(intval(($width - $w) / 2));
            $image->crop($w, $h, $x, 0);
        } else if (($width / $height) < ($w / $h)) {
            $image->resize($w, null, function($constraint) {
                $constraint->aspectRatio();
            });
            $height = $image->getHeight();
            $y = abs(intval(($height - $h) / 2));
            $image->crop($w, $h, 0, $y);
        } else {
            $image->resize($w, $h);
        }
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

        return $auto->auto_id;
    }

    public function updateAuto($data, $id)
    {
        $user = Auth::guard('user')->user();
        $auto = Auto::active()->where('user_id', $user->id)->where('id', $id)->firstOrFail();
        $data['user_id'] = $user->id;
        $data['term'] = empty($data['term']) ? $auto->term : date('Y-m-d', time()+(60*60*24*7*$data['term']));
        $data['status'] = Auto::STATUS_PENDING;
        $data = $this->processSave($data);
        DB::transaction(function() use($data, $auto) {
            $auto->update($data);
            $this->updateOptions($data['options'], $auto, true);
            $this->updateImages($data['images'], $auto);
        });
        return $auto;
    }
}