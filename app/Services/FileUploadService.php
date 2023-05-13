<?php

namespace App\Services;
use App\Helpers\LocalUploadFileHelper;
use Illuminate\Http\UploadedFile;

class FileUploadService{
    public static function storeQuestionFile(UploadedFile $file){
        return LocalUploadFileHelper::organizeAndStorePublicly('question-files', $file);
    }
}