<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use \App\Models\User;
use \App\Models\Question;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('question_answers', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('created_by');
            $table->foreign('created_by')->references('id')->on('users')
                ->cascadeOnDelete()
                ->cascadeOnUpdate();
            $table->unsignedBigInteger(('question_id'));
            $table->foreign('question_id')->references('id')->on('questions')
                ->cascadeOnDelete()
                ->cascadeOnUpdate();
            $table->string('body', 2750);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('question_answers');
    }
};
