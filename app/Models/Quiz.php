<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Quiz extends Model
{
    use HasFactory;

    protected $table = 'quizzes'; // Table name
    protected $primaryKey = 'id'; // Primary key
    protected $keyType = 'int'; // Primary key type

    protected $fillable = [
        'quiz_id', // Foreign key referencing QuizList
        'user_id',
        'question',
        'option', // JSON column for options
        'correct_answer',
    ];

    /**
     * Each question belongs to a specific quiz (QuizList).
     */
    public function quizList()
    {
        return $this->belongsTo(QuizList::class, 'quiz_id', 'quiz_id');
    }

    public function subject()
    {
        return $this->belongsTo(Subject::class);
    }

    
}
