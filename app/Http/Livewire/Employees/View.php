<?php

namespace App\Http\Livewire\Employees;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\Department;
use App\Models\Company;
use App\Models\EmployeesContract;
use App\Models\Bank;
use App\Models\PartTime;
use App\Models\Role;
use App\Models\Salary;
use App\Models\User;
use Livewire\Component;
use Livewire\WithFileUploads;

class View extends Component
{
    use WithFileUploads;
    public $user;
    public $showSavedAlert = false;
    public $showDemoNotification = false;
    public $username;
    public $name;
    public $ID_no;
    public $gender;
    public $phone;
    public $email;
    public $birthday;
    public $address;
    public $image;
    public $ID_image;
    public $license_image;
    public $status;
    public $unemployment = '';
    public $salary = '';
    public $part_time = '';
    public $bank_name = '';
    public $IBAN = '';
    public $start_date;
    public $contract;
    public $signedDate;
    public $company_name;
    public $department_name;
    public $position;
    public $type;
    public $role;
    public function mount(User $user)
    {
        $this->user = $user;
        $this->email = $user->email;
        $this->username = $user->username;
        $this->name = $user->name;
        $this->gender = $user->gender;
        $this->position = $user->position;
        $this->type = $user->type;
        $this->salary = $user->salary;
        $this->part_time = $user->part_time;
        $this->IBAN = $user->IBAN;
        $this->start_date = $user->start_date;
        $this->birthday = $user->birthday;
        $this->phone = $user->phone;
        $this->address = $user->address;
        $this->ID_no = $user->ID_no;
        $this->status = $user->status;
        $this->unemployment = $user->unemployment;
        $this->image = $user->image;
        $this->ID_image = $user->ID_image;
        $this->license_image = $user->license_image;
        $this->role = $user->getRoleNames();
        $getCompany = Company::where('id', '=', $user->company_id)->first()->name;
        $this->company_name = $getCompany;
        $getDepartment = Department::where('id', '=', $user->department_id)->first()->name;
        $this->department_name = $getDepartment;
        if ($user->bank) {
            $getBank = Bank::find($user->bank);
            $this->bank_name = $getBank;
        }
        $getContract = EmployeesContract::where('user_id', '=', $user->id)->first();
        if ($getContract) {
            $this->contract = $getContract->image;
            $this->signedDate = $getContract->date;
        }
    }
    public function render()
    {
        return view('livewire.Employees.View');
    }
}
