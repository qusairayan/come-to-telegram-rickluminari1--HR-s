<?php

namespace App\Http\Livewire\Attendence;

use App\Models\Attendence;
use Livewire\Component;
use Livewire\WithPagination;

class Attendences extends Component
{
    use WithPagination;
    public $search = '';
    public function render()
    {
        if (auth()->user()->hasPermissionTo('viewAttendence')) {
            $attendances = Attendence::leftJoin('users', 'users.id', '=', 'attendence.user_id')
                ->leftJoin('department', 'users.department_id', '=', 'department.id')
                ->select('attendence.*', 'department.name as department_name', 'users.name as user_name')
                ->where('users.name', 'LIKE', '%' . $this->search . '%')->orderBy("attendence.date", "DESC")
                ->paginate(10);
            return view('livewire.attendence.attendence', compact('attendances'));
        } else if (auth()->user()->hasPermissionTo('viewDepAttendence')) {
            $attendances = Attendence::leftJoin('users', 'users.id', '=', 'attendence.user_id')
                ->leftJoin('department', 'users.department_id', '=', 'department.id')
                ->select('attendence.*', 'department.name as department_name', 'users.name as user_name')
                ->where('users.department_id', '=', auth()->user->department_id)
                ->where('users.name', 'LIKE', '%' . $this->search . '%')->orderBy("attendence.date", "DESC")
                ->paginate(10);
            return view('livewire.attendence.attendence', compact('attendances'));
        }
    }
}
