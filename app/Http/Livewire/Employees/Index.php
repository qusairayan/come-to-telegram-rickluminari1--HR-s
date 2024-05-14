<?php

namespace App\Http\Livewire\Employees;

use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;
    public $search = '';
    public function render()
    {
        $users = User::leftJoin('department', 'users.department_id', '=', 'department.id')
            ->leftjoin('company', 'company.id', '=', 'users.company_id')
            ->select('users.*', 'department.name as department_name', 'company.name as company_name')
            ->where('users.name', 'LIKE', '%' . $this->search . '%')
            ->orderBy('id', 'DESC')
            ->paginate(10);
        return view('livewire.Employees.Index', ['users' => $users]);
    }
}
