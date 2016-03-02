<?php

namespace App\Core\Image;

use App\Core\File\SubmittedFile;
use App\Core\File\UploadedTempFile;

class SaveImage
{
    public static function save($image, $model, $column)
    {
        $image = trim($image);
        $submittedImage = new SubmittedImage();
        if (empty($image)) {
            $submittedImage->setImageType(SubmittedImage::FILE_TYPE_EMPTY);
        } elseif ($image === 'same') {
            $submittedImage->setImageType(SubmittedImage::FILE_TYPE_SAME);
        } else {
            $submittedImage->setImageType(SubmittedImage::FILE_TYPE_NEW);
            $tempFile = Uploader::getTempImage($image, false, true);
            $submittedImage->setTempImage($tempFile);
        }

        self::saveFile($submittedImage, $model, $column);
    }

    protected static function saveFile(SubmittedFile $file, $model, $column)
    {
        if ($file->isSame()) {
            return;
        }

        if ($file->isEmpty()) {
            $filePath = public_path($model->getStorePath());
            if (!empty($model->getFile($column)) && file_exists($filePath . '/' . $model->getFile($column))) {
                unlink($filePath . '/' . $model->getFile($column));
            }
            $model->setFile('', $column);
            return ;
        }

        if ($file->isNew()) {
            $tempFile = $file->getTempFile();
            list($filePath, $subDir, $fileName) = self::createPathInfo($model, $tempFile);
            $tempFile->save($filePath . '/' . $subDir, $fileName);
            if (!empty($model->getFile($column)) && file_exists($filePath . '/' . $model->getFile($column))) {
                unlink($filePath . '/' . $model->getFile($column));
            }
            $model->setFile($subDir . '/' . $fileName, $column);
        }
    }

    protected static function createPathInfo($model, UploadedTempFile $tempFile)
    {
        $filePath = public_path($model->getStorePath());
        if (!is_dir($filePath)) {
            mkdir($filePath, 0775, true);
        }

        $subFilesCount = 1000;
        $subDir = intval($model->id / $subFilesCount) + 1;
        if (!file_exists($filePath . '/' . $subDir)) {
            mkdir($filePath . '/' . $subDir);
        }
        $fileName = str_replace('.', '', microtime(true) . '') . '.' . $tempFile->getExtension();

        return [$filePath, $subDir, $fileName];
    }
}