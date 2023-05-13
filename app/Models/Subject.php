<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

class Subject extends Model
{
    use HasFactory;
    use HasSlug;

    public function getSlugOptions() : SlugOptions{
        return SlugOptions::create()
            ->generateSlugsFrom('name')
            ->saveSlugsTo('slug');
    }
    protected $fillable = [
        'name'
    ];

}

