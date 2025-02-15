<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateQuizzesAndQuizListTables extends Migration
{
    public function up()
    {
        // Create the quiz_list table
        Schema::create('quiz_list', function (Blueprint $table) {
            $table->id('id'); // Primary Key
            $table->unsignedBigInteger('user_id');
            $table->string('quiz_name');
            $table->integer('duration'); // Duration in minutes
            $table->string('quiz_set')->nullable();
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });

        // Create the quizzes table
        Schema::create('quizzes', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('quiz_id'); // Foreign Key
            $table->unsignedBigInteger('user_id');
            $table->string('question');
            $table->json('option'); // JSON column for options
            $table->string('correct_answer');
            $table->timestamps();

            $table->foreign('quiz_id')->references('id')->on('quiz_list')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('quizzes');
        Schema::dropIfExists('quiz_list');
    }
}
