<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QuizList extends Model
{
    use HasFactory;

    protected $table = 'quiz_list'; // Table name
    protected $primaryKey = 'quiz_id'; // Primary key column name
    public $incrementing = true; // Set to true if quiz_id is auto-incrementing
    protected $keyType = 'int'; // Data type of the primary key

    protected $fillable = [
        'user_id',
        'quiz_name',
        'duration',
        'quiz_set',
        'start_date',
        'end_date',
    ];

    public function quizzes()
    {
        return $this->hasMany(Quiz::class, 'quiz_id', 'quiz_id'); // Match quiz_id in both tables
    }
}
