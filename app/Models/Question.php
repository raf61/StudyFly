<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    protected $table = 'questions';

    protected $fillable = [
        'created_by',
        'title',
        'body',
        'subject',
        'markdownMode'
    ];

    public function user(){
        return $this->belongsTo(User::class, 'created_by', 'id');
    }
    public function subject(){
        return $this->belongsTo(Subject::class, 'subject', 'id');
    }
    public function files(){
        return $this->hasMany(QuestionFile::class, 'question_id', 'id')->select([
            "filepath"
        ]);
    }
    
    protected $hidden = [
        'created_by',
        'updated_at'
    ];



}
