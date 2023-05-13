<?php

namespace App\Http\Controllers\Upload;
use App\Services\ImageUploadService;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ImageUploadController extends Controller{
    public function store(Request $request){
        
        $this->validate($request, [
            'image' => 'required|image|mimes:jpg,png,jpeg,gif,svg|max:2048',
        ]);

        $filepath = $request->file('image')->getPathName();
        

        if($uploaded_image_url = ImageUploadService::upload($filepath)){
            return [
                "ok" => true,
                "url" => $uploaded_image_url
            ];
        }
        return [
            "ok" => false,
        ];
        

    }
}

