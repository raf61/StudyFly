<?php

namespace App\Http\Controllers\Questions;

use App\Helpers\QuestionSearchHelper;
use App\Helpers\SubjectsHelper;
use App\Helpers\LocalUploadFileHelper;
use App\Http\Controllers\Controller;
use App\Models\Question;
use App\Models\QuestionAnswer;
use App\Models\QuestionFile;
use App\Services\FileUploadService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\File;
use Inertia\Inertia;
use Nette\Utils\DateTime;

class QuestionController extends Controller
{
    public function index(Request $request){
        $questions = QuestionSearchHelper::search(
            $request
        )->orderBy('created_at','desc')
        ->paginate(15)
        ->withQueryString();
        
        return Inertia::render('Questions/Questions', [
            'questions' => $questions
        ]);
    }
    public function indexAsk(){
        
        return Inertia::render('Questions/Ask');
    }
    public function store(Request $request){
        $input = $request->validate([
            'title' => 'required|string|min:10|max:70',
            'body' => 'required|string|max:4096',
            'markdownMode' => 'required|boolean',
            'subject' => 'required|numeric', // It`s the subject id, not the name
            'attachments.*' => [File::types(['jpg','png','jpeg','txt','pptx','docx','pdf','xlsx','xls','gif','doc'])->max(1024 * 2)]
        ]);

        if (isset($input['attachments']) && count($input['attachments'])){
            $attachments = $input['attachments'];
            if (count($attachments) > 3){
                return abort(500);
            }
        }

        $subjects = SubjectsHelper::get();
        if (!in_array($input['subject'], array_map(fn ($s) => $s['id'], $subjects))){
            return abort(500);
        }


        $question = Question::create([
            'created_by' => Auth::user()->id,
            'title' => $input['title'],
            'body' => $input['body'],
            'markdownMode' => $input['markdownMode'],
            'subject' => $input['subject']
        ]);
        
        if (isset($attachments)){
            $questionFiles = [];
            foreach ($attachments as $key => $attachment) {
                array_push($questionFiles, [
                    'filepath' => FileUploadService::storeQuestionFile($attachment),
                    'question_id' => $question->id,
                    'filename' => $attachment->getClientOriginalName(),
                    'created_at' => new DateTime(),
                    'updated_at' => new DateTime()
                ]
                );
            }

            QuestionFile::insert($questionFiles);            
        }


        
        return redirect()->route('question.show', ['question' => $question->id])
        ->with('success', 'You question has been posted!');
    }

    public function show(string $question_id, Request $request){

        $validator = Validator::make([
            'question' => $question_id
        ], [
            'question' => 'required|integer|string',
        ]);
        
        if ($validator->fails()) {
            return abort(404);
        }

        $question = Question::where('questions.id', $question_id)
            ->join('users', 'questions.created_by', '=', 'users.id')
            ->first([
                'questions.id as id',
                'questions.title as title',
                'questions.body as body',
                'questions.markdownMode as markdownMode',
                'questions.subject as subject',
                'questions.created_at as created_at',
                'users.username as username'
            ]);
        if (!$question)
            abort(404);

        $question = $question->toArray();
        
        $questionFiles = QuestionFile::where('question_id', $question['id'])
            ->select(['filename', 'filepath'])
            ->get()
            ->toArray();

        $question['files'] = $questionFiles ?? [];
        
        $answers = QuestionAnswer::where('question_id', $question['id'])
            ->join('users', 'question_answers.created_by','=','users.id')
            ->select([
                'question_answers.body as body',
                'question_answers.created_at as created_at',
                'users.username as username',
            ])
            ->get()
            ->toArray();

        return Inertia::render('Questions/Question', [
            'question' => $question,
            'answers' => $answers ?? []
        ]);
    }

    public function destroy(Question $question, Request $request){
        $user = Auth::user();
        
        if ($question->created_by != $user->id){
            abort(403);
        }

        $question->deleteOrFail();

        return back()->with('info', 'A question has been deleted');


    }

}
