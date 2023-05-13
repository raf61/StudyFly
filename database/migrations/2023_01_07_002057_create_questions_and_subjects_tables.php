<?php

use App\Models\User;
use App\Models\Subject;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('subjects', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug');
            $table->timestamps();
        });


        Schema::create('questions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger(('created_by'));
            $table->foreign('created_by')->references('id')->on('users')
                ->cascadeOnDelete()
                ->cascadeOnUpdate();
            $table->string('title', 70);
            $table->unsignedBigInteger(('subject'));
            $table->foreign('subject')->references('id')->on('subjects')
                ->cascadeOnDelete()
                ->cascadeOnUpdate();
            $table->string('body', 4096);
            $table->boolean('markdownMode')->default(false);
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
        Schema::dropIfExists('questions');
        Schema::dropIfExists('subjects');
    }
};
