<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStudentQuizResultsTable extends Migration
{
    public function up()
    {
        Schema::create('student_quiz_results', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_id')->constrained('users')->onDelete('cascade'); // Link to users table
            $table->foreignId('quiz_id')->constrained('quiz_list')->onDelete('cascade'); // Link to quiz_list table
            $table->integer('score'); // Number of correct answers
            $table->integer('total_questions'); // Total questions in the quiz
            $table->float('percentage'); // Percentage score
            $table->string('status')->default('Pending'); // Pass/Fail or other custom statuses
            $table->timestamps(); // Created and updated timestamps
        });
    }

    public function down()
    {
        Schema::dropIfExists('student_quiz_results');
    }
}
