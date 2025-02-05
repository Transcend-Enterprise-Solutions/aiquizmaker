<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Models\Role;


class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role_id', // Add role_id here
    ];


    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     *
     */

    public function quizzes()
    {
        return $this->belongsToMany(QuizList::class, 'student_quiz_results', 'student_id', 'quiz_id')
            ->withPivot('score');
    }

    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    public function subjects()
    {
        return $this->belongsToMany(Subject::class, 'instructor_subject', 'instructor_id', 'subject_id');
    }


    public function enrolledSubjects()
    {
        return $this->belongsToMany(Subject::class, 'student_subject', 'student_id', 'subject_id');
    }
    

    public function instructorSubjects()
    {
        return $this->belongsToMany(Subject::class, 'instructor_subject', 'instructor_id', 'subject_id');
    }
    

    public function hasRole($role)
    {
        return $this->role->name === $role;
    }


    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
}
