<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    use HasFactory;

    protected $table = 'quizzes'; // Table name for questions
    protected $primaryKey = 'id'; // Primary key

    protected $fillable = [
        'quiz_id',         // Foreign key linking to QuizList
        'user_id',         // User who created the question (if applicable)
        'question',        // The text of the question
        'option',          // JSON-encoded options for the question
        'correct_answer',  // The correct answer
    ];

    /**
     * Relationship: A Question belongs to a QuizList.
     */
    public function quizList()
    {
        return $this->belongsTo(QuizList::class, 'quiz_id', 'quiz_id'); // 'quiz_id' links this question to its quiz
    }

    /**
     * Ensure 'option' is always returned as an array.
     */
    public function getOptionAttribute($value)
    {
        return is_array($value) ? $value : json_decode($value, true) ?? [];
    }
    
    protected $casts = [
        'option' => 'array',
    ];
    /**
     * Ensure 'option' is always saved as JSON.
     */
    public function setOptionAttribute($value)
    {
        $this->attributes['option'] = json_encode($value);
    }

    public function quiz()
    {
        return $this->belongsTo(QuizList::class);
    }
}
