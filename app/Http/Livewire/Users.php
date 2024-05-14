<?php

namespace App\Http\Livewire;

use App\Models\Company;
use App\Models\Department;
use App\Models\User;
use Livewire\Component;

class Users extends Component
{
    public $showSavedAlert = false;
    public $showDemoNotification = false;
    public $company = '';
    public $department = '';
    public $employee = '';
    public $date = '';
    public function report()
    {
        $this->validate([
            'employee' => 'required',
            'date' => 'required|date',
        ]);
        return redirect()->route('reportAttendence', ['id' => $this->employee, 'date' => $this->date])
            ->with(['newTab' => true]);
    }
    public function render()
    {
        $companies = Company::all();
        $departmentsQuery = Department::select('*');
        if ($this->company) {
            $departmentsQuery->where('company_id', '=', $this->company);
        }
        $departments = $departmentsQuery->get();
        $employeesQuery = User::select('*')->where('type', '=', 'full-time');
        if ($this->company) {
            $employeesQuery->where('company_id', '=', $this->company);
        }
        if ($this->department) {
            $employeesQuery->where('department_id', '=', $this->department);
        }
        $employees = $employeesQuery->get();
        // $users = User::leftJoin("department","users.department_id",'=',"department.id")->leftJoin("company",'users.company_id','=','company.id')->select('users.*', 'department.name as department_name','company.name as company_name')->paginate(10);
        return view('livewire.users', compact('companies', 'departments', 'employees'));
    }
}
