<?php

namespace App\Http\Livewire\Promotions;

use App\Models\User;
use App\Models\Promotion;
use App\Models\Company;
use App\Models\Department;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;
    public $search = '';
    public $company = '';
    public $department = '';
    public $user = '';
    public $user_id = '';
    public function render()
    {
        $companies = Company::all();
        $departmentsQuery = Department::select('*');
        if ($this->company) {
            $departmentsQuery->Where('company_id', '=', $this->company);
        }
        $departments = $departmentsQuery->get();
        $usersQuery = User::select('*');
        if ($this->company) {
            $usersQuery->Where('department_id', '=', $this->department);
        }
        $users = $usersQuery->get();
        $promotionsQuery = Promotion::query()
            ->leftJoin('users', 'promotions.user_id', '=', 'users.id')
            ->leftJoin('department', 'department.id', '=', 'users.department_id')
            ->leftJoin('company', 'company.id', '=', 'users.company_id')
            ->select('promotions.*', 'users.name as user_name', 'department.name as department_name', 'company.name as comp_name');
        if ($this->user) {
            $promotionsQuery->where('promotions.user_id', $this->user);
        }
        if ($this->department) {
            $promotionsQuery->where('users.department_id', $this->department);
        }
        if ($this->company) {
            $promotionsQuery->where('users.company_id', $this->company);
        }
        $promotionsQuery->where('users.name', 'LIKE', '%' . $this->search . '%');
        $promotionsQuery->orderBy('from', 'desc');
        $promotions = $promotionsQuery->paginate(10);
        return view('livewire.Promotions.Index', ['promotions' => $promotions, 'departments' => $departments, 'companies' => $companies, 'users' => $users]);
    }
    public function delete($id)
    {
        Promotion::destroy($id);
    }
}
