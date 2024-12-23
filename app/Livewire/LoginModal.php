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
            session()->flash('message', 'Login successful!');
            return redirect()->to('/dashboard');
        } else {
            session()->flash('error', 'Invalid credentials.');
        }
    }

    public function render()
    {
        return view('livewire.login-modal');
    }
}
