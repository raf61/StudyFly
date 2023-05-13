<?php

namespace App\Helpers;
use Illuminate\Support\Facades\Storage;

class LocalFileHelper{

    public static function deletePublic($path){
        Storage::disk('local')->delete('public'.DIRECTORY_SEPARATOR.$path);
    }

}