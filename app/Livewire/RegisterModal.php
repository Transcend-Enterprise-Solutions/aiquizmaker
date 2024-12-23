<?php

namespace App\Livewire;

use App\Models\Role;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;

class RegisterModal extends Component
{
    public $name = '';
    public $email = '';
    public $password = '';
    public $password_confirmation = '';
    public $role = 'student'; // Default role
    public $showModal = false;

    protected $rules = [
        'name' => 'required|string|max:255',
        'email' => 'required|email|unique:users,email',
        'password' => 'required|min:6|confirmed',
        'role' => 'required|in:student,instructor',
    ];

    public function openModal()
    {
        $this->reset(['name', 'email', 'password', 'password_confirmation', 'role']);
        $this->showModal = true;
    }

    public function closeModal()
    {
        $this->reset(['name', 'email', 'password', 'password_confirmation', 'role']);
        $this->showModal = false;
    }

    public function register()
    {
        $this->validate();

        $role = Role::where('name', $this->role)->first();

        if (!$role) {
            session()->flash('error', 'Invalid role.');
            return;
        }

        User::create([
            'name' => $this->name,
            'email' => $this->email,
            'password' => Hash::make($this->password),
            'role_id' => $role->id,
        ]);

        session()->flash('message', 'Registration successful!');
        $this->closeModal();
    }

    public function render()
    {
        return view('livewire.register-modal');
    }
}
