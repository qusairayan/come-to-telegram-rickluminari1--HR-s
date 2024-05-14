<?php

namespace App\Http\Livewire\Attendence;

use App\Models\Company;
use App\Models\Department;
use App\Models\User;
use Livewire\Component;

class ReportAttendance extends Component
{
  public $company = '';
  public $department = '';
  public $employee = '';
  public $date = '';
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
    return view('livewire.attendence.report-attendance', compact('companies', 'departments', 'employees'));
  }
  public function report()
  {
    $this->validate([
      'employee' => 'required|integer',
      'date' => 'required|date',
    ]);
    return redirect()->route('attendence.Report.pdf', ['id' => $this->employee, 'date' => $this->date]);
  }
}
