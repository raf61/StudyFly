<?php

namespace App\Helpers;
use App\Models\Question;
use Illuminate\Http\Request;
use App\Helpers\SubjectsHelper;

class QuestionSearchHelper {

    static public function search(
        Request $request
    ){
        $questions = Question::
        join('users', 'questions.created_by', '=', 'users.id')
        ->select([
            'questions.id as id',
            'questions.title as title',
            'questions.subject as subject',
            'questions.created_at as created_at',
            'users.username as username'
        ]);
        $query_search = $request->query('search');
        $query_subject = $request->query('subject');

        if ($request->query('noAnswers') == '1'){
            $questions = $questions->whereRaw('(select count(id) from question_answers where question_id = questions.id) = 0');
        }
        if (is_string($query_subject)){
            $subjects = SubjectsHelper::get();
            $subject = null;
            foreach ($subjects as $key => $value) {
                if ($value['slug'] == $request->query('subject')){
                    $subject = $value['id'];
                }
            }
            if (!$subject){
                abort(404);
            }
            $questions = $questions->where('subject', $subject);
        }
        if (is_string($query_search)){
            $search = str_replace(
                ['\\', '%', '_'],
                ['\\\\', '\\%', '\\_'],
                $query_search
            );
            $questions = $questions->where('title','LIKE',"%$search%")
            ->orWhere('body','LIKE',"%$search%");
        }

        return $questions;
    }

}