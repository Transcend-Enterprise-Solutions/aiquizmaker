<?php

namespace App\Livewire;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class LoginModal extends Component
{
    public $email = '';
    public $password = '';
    public $showModal = false;

    protected $rules = [
        'email' => 'required|email',
        'password' => 'required|min:6',
    ];

    public function openModal()
    {
        $this->showModal = true;
    }

    public function closeModal()
    {
        $this->reset(['email', 'password']);
        $this->showModal = false;
    }

    public function login()
    {
        $this->validate();
    
        if (Auth::attempt(['email' => $this->email, 'password' => $this->password])) {
            $user = Auth::user(); // Get the authenticated user
    
            toastr()->success('Logged in successfully.');
    
            // Check the role and redirect accordingly
            if ($user->role === 'admin') {
                return redirect()->to('/admin-dashboard');
            } elseif ($user->role === 'instructor') {
                return redirect()->to('/instructor-dashboard');
            } elseif ($user->role === 'student') {
                return redirect()->to('/student/dashboard');
            } else {
                // Default redirection if role is not matched
                session()->flash('error', 'Role not recognized.');
                return redirect()->to('/');
            }
        } else {
            session()->flash('error', 'Invalid credentials.');
        }
    }
    
    public function render()
    {
        return view('livewire.login-modal');
    }
}
