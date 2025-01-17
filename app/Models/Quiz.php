<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Quiz extends Model
{
    use HasFactory;

    protected $table = 'quizzes';
    protected $primaryKey = 'id';
    
    protected $fillable = [
        'quiz_id',
        'user_id',
        'question',
        'option',
        'correct_answer',
    ];

    public function quizList()
    {
        return $this->belongsTo(QuizList::class, 'quiz_id', 'quiz_id'); // Link via quiz_id
    }
}
