<?php

namespace App\Http\Livewire\Leaves;

use App\Models\Leave;
use App\Models\Schedules;
use Livewire\Component;
use Livewire\WithPagination;

class Leaves extends Component
{
    use WithPagination;
    public $search = '';
    public $perPage = 10;
    public $paginationView = 'vendor.pagination.custom';
    public function render()
    {
        $leaves = Leave::leftJoin('users', 'leaves.user_id', '=', 'users.id')
            ->leftJoin('department', 'users.department_id', '=', 'department.id')
            ->select('leaves.*', 'users.name as user_name', 'department.name as department_name')
            ->where('users.name', 'LIKE', '%' . $this->search . '%')
            ->paginate($this->perPage);

        return view('livewire.leaves.leaves', compact('leaves'));
    }
    public function approve(Leave $leave)
    {
        $schedule = Schedules::where("user_id", $leave->user_id)->where("date", $leave->date)->first();
        if ($schedule && ($leave->time == $schedule->from)) {
            $leave->checkin = $schedule->from;
        }
        $leave->status = 1;
        $leave->save();

        return redirect()->route('leaves');
    }
    public function reject(Leave $leave)
    {
        $leave->status = 2;
        $leave->save();
        return redirect()->route('leaves');
    }
}
