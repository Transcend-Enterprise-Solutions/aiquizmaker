<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentQuizResult extends Model
{
    use HasFactory;

    protected $fillable = [
        'student_id',
        'quiz_id',
        'score',
        'total_questions',
        'percentage',
        'status',
    ];

    // Define the quiz relationship
    public function quiz()
    {
        return $this->belongsTo(QuizList::class, 'quiz_id', 'quiz_id');
    }
}
