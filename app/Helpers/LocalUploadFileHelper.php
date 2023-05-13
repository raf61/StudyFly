<?php

namespace App\Helpers;
use Illuminate\Support\Facades\Storage;

class LocalUploadFileHelper{

    static public function organizeAndStorePublicly($path, \Illuminate\Http\UploadedFile $file){
        $rootPath = Storage::disk('local')->path('public/'.$path);
        $todayDir = date("Y") . '/' . date('n') . '/' . date('d');
        if (!is_dir($rootPath . '/' . $todayDir)){
            mkdir($rootPath . '/' . $todayDir, 0777, true, null);
        }
        
        return $file->store($path. '/' . $todayDir, 'public');
        
    }

}