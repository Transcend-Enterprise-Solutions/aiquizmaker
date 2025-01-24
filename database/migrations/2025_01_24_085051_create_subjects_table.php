<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSubjectsTable extends Migration
{
    public function up()
    {
        Schema::create('subjects', function (Blueprint $table) {
            $table->id(); // Primary Key
            $table->string('name'); // Subject Name
            $table->text('description')->nullable(); // Optional description
            $table->unsignedBigInteger('created_by'); // Admin who created the subject
            $table->timestamps(); // Timestamps

            // Foreign key linking to the users table (admin)
            $table->foreign('created_by')->references('id')->on('users')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('subjects');
    }
}

