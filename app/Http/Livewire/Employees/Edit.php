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
use App\Models\SocialSecurity;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;
use Livewire\WithFileUploads;

class Edit extends Component
{
    use WithFileUploads;
    private static $COMPANY_SOCIAL_SECURIT_DEDUCTION_RATE = 14.25;
    private static $EMPLOYEE_SOCIAL_SECURIT_DEDUCTION_RATE = 7.5;
    public $user;
    public $password;
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
    public $bank = '';
    public $IBAN = '';
    public $start_date;
    public $contract;
    public $newContract;
    public $signedDate;
    public $company_id;
    public $department_id;
    public $position;
    public $type;
    public $role;
    public $newImage;
    public $newID_image;
    public $newLicense_image;
    public $Duration_contract = "";
    public $social_security = "";
    public $rules = [
        'name' => 'required',
        'username' => 'required',
        'email' => 'required',
        'gender' => 'required',
        'company_id' => 'required',
        'department_id' => 'required',
        'position' => 'required',
        'type' => 'required',
        'role' => 'required',
        'salary' => 'required|integer',
        'part_time' => 'required',
        'bank' => 'required',
        'IBAN' => 'required',
        'birthday' => 'date',
        'phone' => 'required',
        'address' => 'required',
        'ID_no' => 'required|integer|digits:10',
        "Duration_contract" => 'required|boolean',
        "social_security" => 'required|boolean',
        "password" => 'required|min:6|string',
    ];
    public function mount(User $user)
    {
        $this->user = $user;
        $this->email = $user->email;
        $this->username = $user->username;
        $this->name = $user->name;
        $this->gender = $user->gender;
        $this->company_id = $user->company_id;
        $this->department_id = $user->department_id;
        $this->position = $user->position;
        $this->type = $user->type;
        $this->salary = $user->salary;
        $this->part_time = $user->part_time;
        $this->bank = $user->bank;
        $this->IBAN = $user->IBAN;
        $this->start_date = $user->start_date;
        $this->birthday = $user->birthday;
        $this->phone = $user->phone;
        $this->address = $user->address;
        $this->ID_no = $user->ID_no;
        $this->status = $user->status;
        $this->unemployment = $user->unemployment_date;
        $this->image = $user->image;
        $this->ID_image = $user->ID_image;
        $this->license_image = $user->license_image;
        $this->social_security = $user->social_security;
        $this->Duration_contract = $user->Duration_contract;
        $this->role = $user->getRoleNames();
        $getContract = EmployeesContract::where('user_id', '=', $user->id)->first();
        if ($getContract) {
            $this->contract = $getContract->image;
            $this->signedDate = $getContract->date;
        }
    }
    public function render()
    {
        $departments = Department::all();
        if ($this->company_id != '') {
            $departments = Department::where('company_id', '=', $this->company_id)->get();
        }
        $companies = Company::all();
        $roles = Role::all();
        $banks = Bank::get();
        return view('livewire.Employees.Edit', compact('departments', 'companies', 'roles', 'banks'));
    }
    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }
    public function updatedUsername()
    {
        $this->validate(
            ['username' =>  'unique:users,username,' . $this->user->id],
        );
    }
    public function updatedEmail()
    {
        $this->validate(
            ['email' => 'email:rfc,dns|unique:users,email,' . $this->user->id]
        );
    }
    public function updatedStatus()
    {
        if ($this->status == 0) {
            $this->validate(
                ['unemployment' => 'required|date']
            );
        }
    }
    public function updatedNewContract()
    {
        if ($this->newContract) {
            $validExtensions = ['pdf'];
            $extension = strtolower($this->newContract->getClientOriginalExtension());

            if (!in_array($extension, $validExtensions)) {
                $this->reset('newContract');
                $this->addError('newContract', 'Invalid format. Only PDF file allowed.');
                return;
            }
            $imageName = $this->user->id . '.' . $extension;
            $imagePath = 'public/contracts/' .  $imageName;
            if ($this->contract && Storage::exists('public/contracts/' . $this->contract)) {

                Storage::delete($imagePath);
            }
            // Save the new image with the unique name
            $this->newContract->storeAs('public/contracts/', $imageName);
            $contract = EmployeesContract::where('user_id', '=', $this->user->id)->where('date', '=', $this->signedDate)->first();
            if ($contract) {
                $contract->image = $imageName;
                $contract->save();
            } else {
                $res = EmployeesContract::create([
                    "user_id" => $this->user->id,
                    "date" => $this->signedDate,
                    "image" => $imageName,
                ]);
            }
            $this->reset('contract');
            $this->$contract = $imageName;
        }
    }
    public function updatedImage()
    {
        if ($this->image) {
            $validExtensions = ['jpg', 'jpeg', 'png'];
            $extension = strtolower($this->image->getClientOriginalExtension());

            if (!in_array($extension, $validExtensions)) {
                $this->reset('image');
                $this->addError('image', 'Invalid image format. Only JPG, JPEG, and PNG images are allowed.');
                return;
            }
            $imageName = $this->user->id . '.' . $extension;
            $imagePath = 'public/profile/' .  $imageName;

            if ($this->user->image && Storage::exists('public/profile/' . $this->user->image)) {
                Storage::delete($imagePath);
            }
            // Save the new image with the unique name
            $this->image->storeAs('public/profile/', $imageName);
            $this->user->image = $imageName;
            $this->user->save();
            $this->newImage = asset('storage/profile/' . $this->user->image);
        }
    }
    public function updatedIDImage()
    {
        if ($this->ID_image) {
            $validExtensions = ['jpg', 'jpeg', 'png'];
            $extension = strtolower($this->ID_image->getClientOriginalExtension());
            if (!in_array($extension, $validExtensions)) {
                $this->reset('ID_image');
                $this->addError('ID_image', 'Invalid image format. Only JPG, JPEG, and PNG images are allowed.');
                return;
            }
            $imageName = 'ID_' . $this->user->id . '.' . $extension;
            $imagePath = 'public/profile/' .  $imageName;
            if ($this->user->ID_image && Storage::exists('public/profile/' . $this->user->ID_image)) {
                Storage::delete($imagePath);
            }
            // Save the new image with the unique name
            $this->ID_image->storeAs('public/profile/', $imageName);
            $this->user->ID_image = $imageName;
            $this->user->save();
            $this->newID_image = asset('storage/profile/' . $this->user->ID_image);
        }
    }
    public function updatedLicenseImage()
    {
        $validExtensions = ['jpg', 'jpeg', 'png'];
        $extension = strtolower($this->license_image->getClientOriginalExtension());

        if (!in_array($extension, $validExtensions)) {
            $this->reset('license_image');
            $this->addError('license_image', 'Invalid image format. Only JPG, JPEG, and PNG images are allowed.');
            return;
        }
        $imageName = 'license_' . $this->user->id . '.' . $extension;
        $imagePath = 'public/profile/' .  $imageName;
        if ($this->user->license_image && Storage::exists('public/profile/' . $this->user->license_image)) {
            Storage::delete($imagePath);
        }
        // Save the new image with the unique name
        $this->license_image->storeAs('public/profile/', $imageName);
        $this->user->license_image = $imageName;
        $this->user->save();
        $this->newLicense_image = asset('storage/profile/' . $this->user->license_image);
    }
    public function save()
    {
        if ($this->contract || $this->signedDate) {
            $this->validate([

                'signedDate' => 'required|date',
            ]);
        }
        if ($this->type == 'part-time') {

            $this->validate([
                'part_time' => 'required',
            ], [
                'part_time.required' => 'The Part Time field is required.',
            ]);
        } else {
            $this->part_time = '';
        }
        $this->status = $this->status ? 1 : 0;
        if ($this->status == 0) {
            $this->validate(
                ['unemployment' => 'required|date']
            );
        }
        $this->email = $this->email ?: null;
        if ($this->salary !== $this->user->salary) {
            $Salary_percentage = $this->salary / 100;
            SocialSecurity::where("user_id", $this->user->id)->update([
                "date" => date('Y-m-d'),
                "onEmployee" => $Salary_percentage * self::$EMPLOYEE_SOCIAL_SECURIT_DEDUCTION_RATE,
                "onCompany" => $Salary_percentage * self::$COMPANY_SOCIAL_SECURIT_DEDUCTION_RATE,
            ]);
        }
        $this->user->update([
            'email' => $this->email,
            'username' => $this->username,
            'name' => $this->name,
            'gender' => $this->gender,
            'company_id' => $this->company_id,
            'department_id' => $this->department_id,
            'position' => $this->position,
            'type' => $this->type,
            'salary' => $this->salary,
            'part_time' => $this->part_time,
            'bank' => $this->bank,
            'IBAN' => $this->IBAN,
            'start_date' => $this->start_date,
            'birthday' => $this->birthday,
            'phone' => $this->phone,
            'address' => $this->address,
            'ID_no' => $this->ID_no,
            'status' => $this->status,
            'unemployment_date' => $this->unemployment,
            'Duration_contract' => $this->Duration_contract ?? $this->user->Duration_contract,
            'social_security' => $this->social_security ?? $this->user->social_security,
            "password" =>  $this->password ? Hash::make($this->password) : $this->user->password,
        ]);
        if ($this->type == 'part-time') {
            $partTime = PartTime::where('user_id', $this->user->id)->first();
            if (!$partTime) {

                $part_time = PartTime::create([
                    'user_id' => $this->user->id,
                    'from' => $this->start_date,
                    'status' => 0,
                ]);
            }
        }
        if ($this->signedDate) {
            $contract = EmployeesContract::where('user_id', '=', $this->user->id)->first();
            if ($contract) {
                $contract->update([
                    'date' => $this->signedDate,
                ]);
            } else {
                EmployeesContract::create([
                    "date" => $this->signedDate,
                    "user_id" => $this->user->id,
                    "image" => ""
                ]);
            }
        }
        $this->user->syncRoles($this->role);
        session()->flash('message', 'Profile updated successfully.');
        $this->showSavedAlert = true;
        return redirect('/employees');
    }
}
