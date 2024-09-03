<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Storage;
use Intervention\Image\Encoders\AutoEncoder;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;
use Illuminate\Support\Str;

class ImageHelper
{
    public static function image($file, $path)
    {
        $image = $file;
        $extension = $image->getClientOriginalExtension();
        $fileName = 'media_' . rand(111111, 999999) . '.' . $extension;
        $image->move(public_path($path), $fileName);

        return $fileName;
    }

    public static function removeImage($image, $path)
    {
        $deletedFrom = public_path($path . $image);
        unlink($deletedFrom);
    }
}
