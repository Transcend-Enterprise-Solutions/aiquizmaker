<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\User;

class SearchStudents extends Component
{
    public $search = '';

    public function render()
    {
        // Query users with role 'student' and search functionality
        $users = User::where('role', 'student')
            ->where('name', 'like', '%' . $this->search . '%')
            ->get();

        return view('livewire.search-students', [
            'users' => $users,
        ]);
    }
}
