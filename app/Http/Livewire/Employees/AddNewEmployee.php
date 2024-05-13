<?php

namespace App\Http\Livewire\Employees;

use App\Models\Bank;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Models\User;
use App\Models\Department;
use App\Models\PartTime;
use App\Models\Role;
use App\Models\Company;
use App\Models\EmployeesContract;
use App\Models\Salary;
use GuzzleHttp\Promise\Create;
use Livewire\Component;
use Livewire\WithFileUploads;


class AddNewEmployee extends Component
{
    use WithFileUploads;
    public $user;
    public $showSavedAlert = false;
    public $showDemoNotification = false;
    public $username = '';
    public $name = '';
    public $ID_no = '';
    public $gender = '';
    public $phone = '';
    public $email = '';
    public $birth = '';
    public $address = '';
    public $Duration_contract = "";
    public $social_security =false;
    public $contract;
    public $sign_date="";
    public $image;
    public $ID_image;
    public $license_image;
    public $password = '';
    public $passwordConfirmation = '';
    public $status = 0;
    public $salary = '';
    public $part_time = '';
    public $bank = '';
    public $IBAN = '';
    public $company = '';
    public $department = '';
    public $departmentName = '';
    public $position = '';
    public $type = '';
    public $role = '';
    public $start_date = '';
    protected $rules = [
        'password' => 'required|same:passwordConfirmation|min:6',
        'email' => 'email:rfc,dns|unique:users',
        'username' => ['required', 'unique:users', 'max:255'],
        'name' => 'required',
        'gender' => 'required',
        'company' => 'required',
        'department' => 'required',
        'position' => 'required',
        'type' => 'required',
        'role' => 'required',
        'salary' => 'required|integer',
        'start_date' => 'required|date',
        'ID_no' => 'required|int|digits:10',
        'image' => 'nullable|mimes:jpg,png,jpeg',
        'ID_image' => 'nullable|mimes:jpg,png,jpeg',
        'license_image' => 'nullable|mimes:jpg,png,jpeg',
        "Duration_contract"=>'required|boolean',
        "social_security"=>'required|boolean',
    ];
    public function updatedUsername()
    {
        $this->validate(['username' => 'required|unique:users']);
    }
    public function updatedDepartment()
    {
        $this->departmentName = Department::find($this->department)->name;
    }
    public function updated($propertyName)
    {
        // $this->validateOnly($propertyName);
    }
    public function add(){
        $this->validate([
            'password' => 'required|same:passwordConfirmation|min:6',
            'username' => ['required', 'unique:users', 'max:255'],
            'name' => 'required',
            'email' => 'email:rfc,dns|unique:users',
            'gender' => 'required',
            'company' => 'required',
            'department' => 'required',
            'position' => 'required',
            'type' => 'required',
            'role' => 'required',
            'salary' => 'required|integer',
            'bank' => 'integer',
            'start_date' => 'required|date',
            'ID_no' => 'required|integer|digits:10',
            'image' => 'nullable|mimes:jpg,png,jpeg',
            'ID_image' => 'nullable|mimes:jpg,png,jpeg',
            'license_image' => 'nullable|mimes:jpg,png,jpeg',
            "Duration_contract"=>'required|boolean',
            // "social_security"=>'required|boolean',
        ]);
        // dd($this->sign_date);
        if ($this->contract ||$this->sign_date) {
            $this->validate([
                // 'contract' => 'mimes:pdf',
                'sign_date' => 'required|date',
              ]);
            
            }
        if ($this->email == '') {
            $this->email = null;
        }

        if($this->type =='part-time'){
            $this->validate(['part_time' => 'required']);
        }
        $user = User::create([
            'name' => $this->name,
            'email' => $this->email,
            'username' => $this->username,
            'company_id' => $this->company,
            'department_id' => $this->department,
            'remember_token' => Str::random(10),
            'password' => Hash::make($this->password),
            'phone' => $this->phone,
            'address' => $this->address,
            'gender' => $this->gender,
            'position' => $this->position,
            'type' => $this->type,
            'salary' => $this->salary,
            'bank' => $this->bank,
            'IBAN' => $this->IBAN,
            'part_time' => $this->part_time,
            'start_date' => $this->start_date,
            'ID_no' => $this->ID_no,
            'birthday' => $this->birth,
            'Duration_contract' => $this->Duration_contract,
            'social_security' => 0,
        ]);

        if($this->type =='part-time'){

            $part_time=PartTime::create([
                'user_id'=> $user->id,
                'from'=> $this->start_date,
                'status'=> 0,
            ]);
        }



        $user->assignRole($this->role);


        if($this->bank){
            
            $this->validate([
                'IBAN' => 'required',
              ]);

              $salary=Salary::Create([
                "user_id"=>$user->id,
                "bank"=>$this->bank,
                "IBAN"=>$this->IBAN,
                "type"=>$this->part_time,
                "amount"=>$this->salary,
              ]);
              $salary->save();
        }

        if ($this->contract) {
            $contractPath = $this->contract->storeAs('public/contracts/', $user->id . '.' . $this->contract->getClientOriginalExtension());

            $contract=EmployeesContract::create([
                "user_id" =>$user->id,
                "image" =>$user->id . '.' . $this->contract->getClientOriginalExtension(),
                "date" =>$this->sign_date,
            ]);
            $contract->save();
        }


        if ($this->image) {
            $imagePath = $this->image->storeAs('public/profile/', $user->id . '.' . $this->image->getClientOriginalExtension());

            $user->image = $user->id . '.' . $this->image->getClientOriginalExtension();
            $user->save();
        }

        if ($this->ID_image) {
            $imagePath = $this->ID_image->storeAs('public/profile/', 'ID_' . $user->id . '.' . $this->ID_image->getClientOriginalExtension());

            $user->ID_image = 'ID_' . $user->id . '.' . $this->ID_image->getClientOriginalExtension();
            $user->save();
        }

        if ($this->license_image) {
            $imagePath = $this->license_image->storeAs('public/profile/', 'license_' . $user->id . '.' . $this->license_image->getClientOriginalExtension());

            $user->license_image = 'license_' . $user->id . '.' . $this->license_image->getClientOriginalExtension();
            $user->save();
        }


        return redirect('/employees');
    }

    public function render()
    {
        $companies = Company::all();

        $departments = Department::leftJoin('company', 'company.id', '=', 'department.company_id')
            ->select('department.*', 'company.name as company_name')
            ->get();

        if ($this->company != '') {
            $departments = Department::leftJoin('company', 'company.id', '=', 'department.company_id')
                ->select('department.*', 'company.name as company_name')->where('company_id', '=', $this->company)
                ->get();
        }

        $roles = Role::all()->where('name', '!=', 'admin');
        $banks = Bank::get();


        return view('livewire.employees.addNewEmployee', compact('departments', 'companies', 'roles','banks'));
    }
}