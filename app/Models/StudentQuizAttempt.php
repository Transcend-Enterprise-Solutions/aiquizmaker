<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentQuizAttempt extends Model
{
    use HasFactory;

    // Define the fields that are mass assignable
    protected $fillable = [
        'student_id',
        'quiz_id',
        'question_id',
        'answer',
        'is_correct',
    ];


    public function student()
    {
        return $this->belongsTo(Student::class);
    }
    
    public function quiz()
    {
        return $this->belongsTo(Quiz::class);
    }
    
    public function question()
    {
        return $this->belongsTo(Question::class);
    }

    // Define the relationship between the student_quiz_attempts and questions tables
}
