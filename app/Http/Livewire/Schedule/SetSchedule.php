<?php

namespace App\Http\Livewire\Schedule;

use App\Models\Company;
use App\Models\User;
use App\Models\Department;
use App\Models\Schedules;
use Carbon\Carbon;
use Livewire\Component;

class SetSchedule extends Component
{
    public $company = '';
    public $department = '';
    public $user;
    public $offDay = [];
    public $dateFrom;
    public $dateTo;
    public $timeFrom;
    public $timeTo;
    public function render()
    {
        $companies = Company::all();
        $departments = Department::all();
        $users = User::where("status", 1)->get();
        return view('livewire.schedule.setSchedule', compact('users', 'departments', 'companies'));
    }
    public function save()
    {
        $start_date = Carbon::parse($this->dateFrom);
        $end_date = Carbon::parse($this->dateTo);
        $current_date = $start_date->copy();

        for ($i = 0; $current_date->lte($end_date); $i++) {
            $dayName = $current_date->format('l');
            Schedules::create([
                'user_id' => $this->user,
                'date' => $current_date->toDateString(),
                'day' => $dayName,
                'from' => $this->timeFrom,
                'to' => $this->timeTo,
                'off-day' => in_array($dayName, $this->offDay) == true ? 1 : null,
            ]);
            $current_date->addDay(); // Move to the next day
        }
        return redirect()->route("schedule");
    }
}
