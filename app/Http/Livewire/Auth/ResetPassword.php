<?php

namespace App\Http\Livewire\Auth;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;

class ResetPassword extends Component
{
    public $email = '';
    public $password = '';
    public $passwordConfirmation = '';
    public function render()
    {
        return view('livewire.Auth.Reset-Password');
    }
    public function resetPassword()
    {
        $this->validate(['email' => 'required|email|exists:users', 'password' => 'required|same:passwordConfirmation|min:6'], ['email.exists' => 'The Email Address must be in our database.']);
        $user = User::where('email', $this->email)->first();
        $user->update(['password' => Hash::make($this->password)]);
        return redirect()->route("login");
    }
}
