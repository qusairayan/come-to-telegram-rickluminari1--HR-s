<?php

namespace App\Http\Livewire\Schedule;

use App\Models\Company;
use App\Models\User;
use App\Models\Department;
use App\Models\Schedules;
use Livewire\Component;
use Livewire\WithPagination;

class Schedule extends Component
{
    use WithPagination;
    public $user;
    public $department;
    public $company;
    public $dateFrom;
    public $dateTo;
    // for update
    public $editDate = null;
    public $editFrom = null;
    public $editTo = null;
    public $name = null;
    public $off = null;
    public $schduleId = null;
    public function render()
    {
        $companies = Company::all();
        $department = Department::select('*');
        if ($this->company) {
            $department->where('company_id', '=', $this->company);
        }
        $departments = $department->get();
        $employeesQuery = User::select('*')->where('status', '=', 1);
        if ($this->company) {
            $employeesQuery->where('company_id', '=', $this->company);
        }
        if ($this->department) {
            $employeesQuery->where('department_id', '=', $this->department);
        }
        $users = $employeesQuery->get();
        // $this->department = auth()->user()->department_id;
        $schdules = Schedules::select('*', 'off-day as off')->where('user_id', $this->user)
            ->whereBetween('date', [$this->dateFrom, $this->dateTo])
            ->paginate(31);
        // $departments = Department::all();
        // $users = User::where('department_id', '=', $this->department)
        //     ->where('status', '=', 1)
        //     ->get();
        return view('livewire.schedule.schedule',  ['users' => $users, 'schdules' => $schdules, 'departments' => $departments,"companies"=>$companies]);
    }
    public function edit($userId, $name, $from, $to, $schduleId, $off, $date)
    {
        $this->name = User::where("id",$userId)->pluck("name")[0];
        $this->editFrom = $from;
        $this->editTo = $to;
        $this->off = $off == 1 ? true : false;
        $this->editDate = $date;
        $this->schduleId = $schduleId;
    }
    public function save()
    {
        $this->validate([
            'editFrom' => 'required',
            'editTo' => 'required',
            'off' => 'required|boolean',
        ]);
        Schedules::where('id',$this->schduleId)->update([
            'from' => $this->editFrom,
            'to' => $this->editTo,
            'off-day' => $this->off == 1 ? 1 : NULL,
        ]);
        return redirect()->route("schedule");
    }
}
