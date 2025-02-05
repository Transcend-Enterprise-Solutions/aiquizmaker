<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QuizList extends Model
{
    use HasFactory;

    protected $table = 'quiz_list'; // Table name for quizzes
    protected $primaryKey = 'quiz_id'; // Primary key
    public $incrementing = true;
    protected $keyType = 'int';

    protected $fillable = [
        'user_id',
        'quiz_name',
        'duration',
        'quiz_set',
        'start_date',
        'end_date',
        'subject_id',
    ];

    public function questions()
    {
        return $this->hasMany(Quiz::class, 'quiz_id', 'quiz_id'); // Link quizzes via the 'quiz_id' field
    }
    
    public function quizLists()
    {
        return $this->hasMany(QuizList::class, 'subject_id', 'id'); // Link quiz lists to subjects
    }
        
    public function subject()
    {
        return $this->belongsTo(Subject::class);
    }

    public function quizzes()
    {
        return $this->hasMany(Question::class, 'quiz_id', 'quiz_id'); // 'quiz_id' is the foreign key in the questions table
    }
}
