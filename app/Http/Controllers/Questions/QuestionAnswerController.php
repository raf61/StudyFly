<?php

namespace App\Http\Controllers\Questions;

use App\Http\Controllers\Controller;
use App\Models\Question;
use App\Models\QuestionAnswer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class QuestionAnswerController extends Controller
{
    public function store(string $question, Request $request) {

        Question::findOrFail($question);
        $input = $request->validate([
            'body' => 'required|string|min:20|max:2750',
        ]);

        QuestionAnswer::create([
            'body' => $input['body'],
            'question_id' => $question,
            'created_by' => Auth::user()->id
        ]);


        return redirect()->back();

    }

}
