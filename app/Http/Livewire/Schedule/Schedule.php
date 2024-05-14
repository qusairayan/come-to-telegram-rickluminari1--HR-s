<?php

namespace App\Http\Livewire\Schedule;

use App\Models\User;
use App\Models\Department;
use App\Models\Schedules;
use Livewire\Component;
use Livewire\WithPagination;

class Schedule extends Component
{
    use WithPagination;
    public $perPage = 100;
    public $paginationView = 'vendor.pagination.custom';
    public $user;
    public $department = 1;
    public $dateFrom;
    public $dateTo;
    public function render()
    {
        if (!auth()->user()->hasPermissionTo('setSchedule')) {
            $this->department = auth()->user()->department_id;
        }
        $schdules = Schedules::select('*')->where('user_id', $this->user)
            ->whereBetween('date', [$this->dateFrom, $this->dateTo])
            ->paginate($this->perPage);

        $departments = Department::all();
        $users = User::where('department_id', '=', $this->department)
            ->where('status', '=', 1)
            ->get();
        return view('livewire.schedule.schedule',  ['users' => $users, 'schdules' => $schdules, 'departments' => $departments]);
    }
}
