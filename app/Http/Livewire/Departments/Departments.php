<?php

namespace App\Http\Livewire\Departments;

use App\Models\Company;
use App\Models\Department;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithPagination;

class Departments extends Component
{
    use WithPagination;
    public $search = '';
    public $paginate = 10;
    public $name = '';
    public $company = '';
    public $idEdit = '';
    public $nameEdit = '';
    public $companyEdit = '';
    public function render()
    {
        $companies = Company::all();
        $departments = Department::select(
            '*',
            'department.name as dep_name',
            'department.id as dep_id',
            'company.name as company_name',
            DB::raw('(SELECT COUNT(*) FROM users WHERE users.department_id = department.id) as user_count')
        )
            ->leftJoin('company', 'company.id', '=', 'department.company_id')
            ->where('department.name', 'LIKE', '%' . $this->search . '%')
            ->paginate($this->paginate);
        return view('livewire.departments.departments', ['departments' => $departments, 'companies' => $companies]);
    }
    public function addDepartment()
    {
        $this->validate([
            'name' => 'required',
            'company' => 'required'
        ]);
        Department::create([
            'name' => $this->name,
            'company_id' => $this->company
        ]);
        return redirect(route('departments'));
    }
    public function editShow($id)
    {
        $department = Department::where('id', '=', $id)->first();
        $this->idEdit = $id;
        $this->companyEdit = $department->company_id;
        $this->nameEdit = $department->name;
    }
    public function saveEdit()
    {
        $this->validate([
            'nameEdit' => 'required',
            'companyEdit' => 'required'
        ]);
        $department = Department::find($this->idEdit);
        $department->name = $this->nameEdit;
        $department->company_id = $this->companyEdit;
        $department->save();
        return redirect(route('departments'));
    }
}
