<?php

namespace App\Services;

use \App\Helpers\ImgurUploadHelper;

class ImageUploadService{

    

    public static function upload($filename){

        $imgurUploadHelper = new ImgurUploadHelper(
            env("IMGUR_UPLOAD_URL"),
            env("IMGUR_CLIENT_ID")
        );

        return $imgurUploadHelper->upload($filename);
        
    }
}

