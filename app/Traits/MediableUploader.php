<?php

namespace App\Traits;

use Plank\Mediable\Facades\MediaUploader;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\File\File;
use Image;
use Plank\Mediable\Media;

trait MediableUploader
{
    public function uploadFileViaObj($fileObj, $fileOps = [])
    {
        try {
            $media = MediaUploader::fromSource($fileObj)
                ->setAllowedAggregateTypes([Media::TYPE_IMAGE, Media::TYPE_IMAGE_VECTOR])
                ->toDestination(config('mediable.default_disk'), (isset($fileOps) && array_key_exists('location', $fileOps) && !empty($fileOps['location'])) ? $fileOps['location'] : '/') // If location not pass then, file upload on root directory on disk
                ->useFilename((isset($fileOps) && array_key_exists('fileName', $fileOps) && !empty($fileOps['fileName'])) ? $fileOps['fileName'] : self::createFileName())
                ->upload();
            return $media;
        } catch (\Throwable $th) {
            return $th;
        }
    }

    public function uploadFileViaBase64($base64String, $fileOps = [])
    {
        try {
            $extension = explode('/', mime_content_type($base64String))[1];
            $image = Image::make($base64String)->encode($extension);
            $media = MediaUploader::fromString($image)
                ->setAllowedAggregateTypes([Media::TYPE_IMAGE, Media::TYPE_IMAGE_VECTOR])
                ->toDestination(config('mediable.default_disk'), (isset($fileOps) && array_key_exists('location', $fileOps) && !empty($fileOps['location'])) ? $fileOps['location'] : '/') // If location not pass then, file upload on root directory on disk
                ->useFilename((isset($fileOps) && array_key_exists('fileName', $fileOps) && !empty($fileOps['fileName'])) ? $fileOps['fileName'] : self::createFileName())
                ->upload();
            return $media;
        } catch (\Throwable $th) {
            return $th;
        }
    }

    public function uploadFileViaUrl($imageUrl, $fileOps = [])
    {
        try {
            $media = MediaUploader::fromSource($imageUrl)
                ->setAllowedAggregateTypes([Media::TYPE_IMAGE, Media::TYPE_IMAGE_VECTOR])
                ->toDestination(config('mediable.default_disk'), (isset($fileOps) && array_key_exists('location', $fileOps) && !empty($fileOps['location'])) ? $fileOps['location'] : '/') // If location not pass then, file upload on root directory on disk
                ->useFilename((isset($fileOps) && array_key_exists('fileName', $fileOps) && !empty($fileOps['fileName'])) ? $fileOps['fileName'] : self::createFileName())
                ->upload();
            return $media;
        } catch (\Throwable $th) {
            return $th;
        }
    }

    protected static function createFileName()
    {
        return sprintf(
            '%04x%04x-%04x-%04x-%04x-%04x%04x%04x',

            // 32 bits for "time_low"
            mt_rand(0, 0xffff),
            mt_rand(0, 0xffff),

            // 16 bits for "time_mid"
            mt_rand(0, 0xffff),

            // 16 bits for "time_hi_and_version",
            // four most significant bits holds version number 4
            mt_rand(0, 0x0fff) | 0x4000,

            // 16 bits, 8 bits for "clk_seq_hi_res",
            // 8 bits for "clk_seq_low",
            // two most significant bits holds zero and one for variant DCE1.1
            mt_rand(0, 0x3fff) | 0x8000,

            // 48 bits for "node"
            mt_rand(0, 0xffff),
            mt_rand(0, 0xffff),
            mt_rand(0, 0xffff)
        );
    }
}
