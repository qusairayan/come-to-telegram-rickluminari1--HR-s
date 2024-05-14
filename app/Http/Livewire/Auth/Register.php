<?php

namespace App\Http\Livewire\Auth;

use Livewire\Component;
use App\Models\User;
use App\Models\Department;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class Register extends Component
{
    public $username = '';
    public $name = '';
    public $gender = '';
    public $phone = '';
    public $email = '';
    public $birth = '';
    public $address = '';
    public $image = '';
    public $password = '';
    public $passwordConfirmation = '';
    public $role = 10;
    public $status = 0;
    public $salary = '';
    public $type = 1;
    public $company = '';
    public $department = '';
    public $position = '';
    public $vaction_blance = 0;
    public function mount()
    {
        if (auth()->user()) {
            return redirect()->intended('/dashboard');
        }
    }
    public function updatedEmail()
    {
        $this->validate(['email' => 'required|email:rfc,dns|unique:users']);
    }
    public function updatedUsername()
    {
        $this->validate(['username' => 'required|unique:users']);
    }
    public function register()
    {
        $this->validate([
            'email' => 'required',
            'password' => 'required|same:passwordConfirmation|min:6',
            'username' => 'required',
            'name' => 'required|max:100',
            'gender' => 'required|max:100',
            'company' => 'required',
            'department' => 'required',
            'position' => 'required',
            'salary' => 'required|integer',
            'type' => 'required',

        ]);
        $user = User::create([
            'name' => $this->name,
            'email' => $this->email,
            'username' => $this->username,
            'company_id' => $this->company,
            'department_id' => $this->department,
            'remember_token' => Str::random(10),
            'password' => Hash::make($this->password),
            'phone' => $this->phone,
            'addres' => $this->addres,
            'gender' => $this->gender,
            'position' => $this->position,
            'salary' => $this->salary,
            'type' => $this->type,
            'role' => $this->position,
        ]);
        auth()->login($user);
        return redirect('/profile');
    }
    public function render()
    {
        $department = Department::all();
        return view('livewire.auth.register', compact('department'));
    }
}
