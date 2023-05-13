<?php

namespace App\Helpers;
use App\Models\Subject;
use Illuminate\Support\Facades\Cache;

class SubjectsHelper {

    static public function get(){
        $cached = Cache::store('file')->get('subjects');
        if ($cached){
            return $cached;
        }
        $records = Subject::all(['id','name','slug'])->toArray();
        Cache::store('file')->put('subjects', $records, 3600);
        return $records;
    }

}