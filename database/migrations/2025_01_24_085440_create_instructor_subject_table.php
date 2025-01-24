<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInstructorSubjectTable extends Migration
{
    public function up()
    {
        Schema::create('instructor_subject', function (Blueprint $table) {
            $table->id(); // Primary Key
            $table->unsignedBigInteger('instructor_id'); // Foreign key for instructor
            $table->unsignedBigInteger('subject_id'); // Foreign key for subject
            $table->timestamps();

            // Foreign key constraints
            $table->foreign('instructor_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('subject_id')->references('id')->on('subjects')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('instructor_subject');
    }
}
