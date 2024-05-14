<?php

namespace App\Http\Livewire\Auth;

use Livewire\Component;
use App\Models\User;
use Illuminate\Notifications\Notifiable;
use App\Notifications\ResetPassword;

class ForgotPassword extends Component
{
    use Notifiable;
    public $mailSentAlert = false;
    public $email = '';
    public function render()
    {
        return view('livewire.Auth.Forgot-Password');
    }
    public function recoverPassword()
    {
        $this->validate(['email' => 'required|email|exists:users'], ['email.exists' => 'The Email Address must be in our database.']);
        $user = User::where('email', $this->email)->first();
        $this->notify(new ResetPassword($user->id));
        $this->mailSentAlert = true;
    }
}
