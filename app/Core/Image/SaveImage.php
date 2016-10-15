<?php

namespace App\Core\Image;

use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;

class SaveImage
{
    public static function save($image, $model, $column = 'image')
    {
        $image = trim($image);
        if ($image === 'same') {
            return null;
        } else if (empty($image)) {
            $filePath = public_path($model->getStorePath());
            if (!empty($model->getFile($column)) && file_exists($filePath . '/' . $model->getFile($column))) {
                unlink($filePath . '/' . $model->getFile($column));

                $pathInfo = pathinfo($filePath . '/' . $model->getFile($column));
                self::deleteFolder($pathInfo['dirname'] . '/' . $pathInfo['filename']);
            }
            $model->setFile('', $column);
            return '';
        } else {
            $file = new SubmittedImage();
            $file->setImageType(SubmittedImage::FILE_TYPE_NEW);
            $tempFile = Uploader::getTempImage($image, false, true);
            $file->setTempImage($tempFile);

            $tempFile = $file->getTempFile();
            list($filePath, $subDir, $fileName) = self::createPathInfo($model, $tempFile->getExtension());
            $tempFile->save($filePath . '/' . $subDir, $fileName);
            if (!empty($model->getFile($column)) && file_exists($filePath . '/' . $model->getFile($column))) {
                unlink($filePath . '/' . $model->getFile($column));

                $pathInfo = pathinfo($filePath . '/' . $model->getFile($column));
                self::deleteFolder($pathInfo['dirname'] . '/' . $pathInfo['filename']);
            }
            $model->setFile($subDir . '/' . $fileName, $column);
            return $subDir . '/' . $fileName;
        }
    }

    public static function createPathInfo($model, $extension)
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
        $fileName = str_replace('.', '', microtime(true) . '') . '.' . $extension;

        return [$filePath, $subDir, $fileName];
    }

    public static function deleteFolder($path)
    {
        if (is_dir($path) === true) {
            $files = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($path), RecursiveIteratorIterator::CHILD_FIRST);
            foreach ($files as $file) {
                if (in_array($file->getBasename(), array('.', '..')) !== true) {
                    if ($file->isDir() === true) {
                        rmdir($file->getPathName());
                    } else if (($file->isFile() === true) || ($file->isLink() === true)) {
                        unlink($file->getPathname());
                    }
                }
            }
            return rmdir($path);
        } else if ((is_file($path) === true) || (is_link($path) === true)) {
            return unlink($path);
        }
        return false;
    }
}