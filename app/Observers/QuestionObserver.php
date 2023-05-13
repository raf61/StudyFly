<?php

namespace App\Observers;

use App\Helpers\LocalFileHelper;
use App\Models\Question;

class QuestionObserver
{
    /**
     * Handle the Question "created" event.
     *
     * @param  \App\Models\Question  $question
     * @return void
     */
    public function created(Question $question)
    {
        //
    }

    /**
     * Handle the Question "updated" event.
     *
     * @param  \App\Models\Question  $question
     * @return void
     */
    public function updated(Question $question)
    {
        //
    }

    /**
     * Handle the Question "deleted" event.
     *
     * @param  \App\Models\Question  $question
     * @return void
     */
    public function deleting(Question $question)
    {

        $questionFiles = $question->files->toArray();
        foreach ($questionFiles as $key => $file) {
            try{
                LocalFileHelper::deletePublic($file['filepath']);
            }
            catch(\Exception $e){} // Ugly but no implementation needed here
        }
        
    }

    /**
     * Handle the Question "restored" event.
     *
     * @param  \App\Models\Question  $question
     * @return void
     */
    public function restored(Question $question)
    {
        //
    }

    /**
     * Handle the Question "force deleted" event.
     *
     * @param  \App\Models\Question  $question
     * @return void
     */
    public function forceDeleted(Question $question)
    {
        //
    }
}
