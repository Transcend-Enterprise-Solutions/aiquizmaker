<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subject extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'description', 'created_by'];

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }



    public function students()
    {
        return $this->belongsToMany(User::class, 'student_subject', 'subject_id', 'student_id');
    }

    public function quizzes()
    {
        return $this->hasMany(QuizList::class, 'subject_id'); // Ensure 'subject_id' exists in the QuizList table
    }
    
    
    public function quizLists()
    {
        return $this->hasMany(QuizList::class, 'subject_id', 'id');
    }
    
    public function instructors()
    {
        return $this->belongsToMany(User::class, 'instructor_subject', 'subject_id', 'instructor_id');
    }
}
