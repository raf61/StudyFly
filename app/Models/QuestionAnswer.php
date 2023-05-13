<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QuestionAnswer extends Model
{
    use HasFactory;

    protected $fillable = [
        'body',
        'question_id',
        'created_by'
    ];

    public function user(){
        return $this->belongsTo(User::class, 'created_by', 'id');
    }

}
