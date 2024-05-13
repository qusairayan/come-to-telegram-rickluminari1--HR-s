<?php

namespace App\Http\Livewire\Schedule;

use App\Http\Livewire\Users;
use App\Models\Company;
use App\Models\User;
use App\Models\Department;
use App\Models\Schedule;
use App\Models\Shift;
use App\Models\Schedules;
use Carbon\Carbon;
use DateTime;
use Illuminate\Support\Facades\Redirect;
use Livewire\Component;
use Livewire\WithPagination;
use Spatie\Permission\Models\Permission;

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
    // use WithPagination;
    // public $user;
    // public $department = 1;
    // public $week = 1;
    // public $dateSelects = [];
    // public $shift = [];
    // public $offs = [];
    // public $today;
    // public $endOfWeek;
    // public $totalDays;
    // public $search = "";
    // protected $rules = [
    //     'user' => 'required',
    //     'shift.*.from' => 'required|date_format:H:i',
    //     'shift.*.to' => 'required|date_format:H:i|after:shift.*.from',
    // ];
    // protected $messages = [
    //     'shift.*.from.required' => 'Please enter a from time for :attribute',
    //     'shift.*.from.date_format' => 'The :attribute must be in the format HH:MM',
    //     'shift.*.to.required' => 'Please enter a to time for :attribute',
    //     'shift.*.to.date_format' => 'The :attribute must be in the format HH:MM',
    //     'shift.*.to.after' => 'The :attribute must be after from time',
    // ];
    // public $showSavedAlert = false;
    // public function updated()
    // {
    //     $this->showSavedAlert = false;
    // }

    // public function updatedUser()
    // {
    //     $this->week = 1;
    // }

    // public function updatedShift()
    // {
    //     foreach ($this->shift as $date => $shiftId) {
    //         if (isset($shiftId['off'])) {
    //             $this->offs[$date] = true;
    //         } else {
    //             if (isset($this->offs[$date])) {
    //                 unset($this->offs[$date]);
    //             }
    //         }
    //     }
    // }
    // public function save()
    // {
    //     $this->resetErrorBag('user');
    //     $this->resetErrorBag('shift');
    //     session()->forget("success");

    //     if (!$this->user) {
    //         $this->addError('user', 'Select the user');
    //         return;
    //     }
    //     if (count($this->shift) == $this->totalDays) {
    //         foreach ($this->shift as $date => $shiftId) {
    //             if (!isset($shiftId["off"])) {
    //                 if (!isset($shiftId["from"]) || !isset($shiftId["to"])) {
    //                     $this->addError('shift', 'From and To selections must be filled.');
    //                     return;
    //                 }
    //             }
    //         }
    //     } else {
    //         $this->addError('shift', 'Set one week schedule at least');
    //         return;
    //     }
    //     foreach ($this->shift as $date => $shiftId) {
    //         $dateTem = new DateTime($date);
    //         $dayName = $dateTem->format('l');
    //         Schedules::create([
    //             'user_id' => $this->user,
    //             'date' => $date,
    //             'day' => $dayName,
    //             'from' => $shiftId['from'] ?? null,
    //             'to' => $shiftId['to'] ?? null,
    //             'off-day' => $shiftId['off'] ?? null,
    //         ]);
    //         $this->showSavedAlert = true;
    //         session()->flash("success", "Shift schedule created successfully.");
    //         $this->render();
    //     }
    // }
    // public function render()
    // {
    //     if ($this->user != null) {
    //         $preSchedule = Schedules::where('user_id', '=', $this->user)
    //             ->whereDate('date', '>', date('Y-m-d'))
    //             ->latest('id') // Order the records by date in descending order
    //             ->first();      // Retrieve the first (latest) record that matches the conditions
    //         if ($preSchedule) {
    //             $this->today = new \DateTime($preSchedule->date);
    //         } else {
    //             $this->today = new \DateTime();
    //         }
    //         $this->today->modify('+1 day');
    //         $this->endOfWeek = clone $this->today;
    //         $this->endOfWeek->modify('next Saturday');
    //         if (auth()->user()->hasPermissionTo('setSchedule')) {
    //             $departments = Department::all();
    //             $companies = Company::all();
    //             $users = User::leftJoin('department', 'department.id', '=', 'users.department_id')
    //                 ->select('users.*', 'users.name as user_name', 'department.name as department_name')
    //                 ->where('users.status', '=', 1)
    //                 // ->where('users.department_id', '=', $this->department)
    //                 ->where('users.name', 'LIKE', '%' . $this->search . '%')->get();
    //             return view('livewire.schedule.setSchedule', compact('users', 'departments', "companies",));
    //         } else if (auth()->user()->hasPermissionTo('setDepSchedule')) {
    //             $this->department = auth()->user()->department_id;
    //             $users = User::leftJoin('department', 'department.id', '=', 'users.department_id')
    //                 ->select('users.*', 'users.name as user_name', 'department.name as department_name')
    //                 ->where('users.status', '=', 1)
    //                 // ->where('users.department_id', '=', $this->department)
    //                 ->where('users.name', 'LIKE', '%' . $this->search . '%')->get();
    //             return view('livewire.schedule.setSchedule', compact('users'));
    //         } else {
    //             return view('404');
    //         }
    //     } else {
    //         $this->today = new \DateTime();
    //         $this->today->modify('+1 day');
    //         $this->endOfWeek = clone $this->today;
    //         $this->endOfWeek->modify('next Saturday');
    //         if (auth()->user()->hasPermissionTo('setSchedule')) {
    //             $departments = Department::all();
    //             $users = User::leftJoin('department', 'department.id', '=', 'users.department_id')
    //                 ->select('users.*', 'users.name as user_name', 'department.name as department_name')
    //                 ->where('users.status', '=', 1)
    //                 // ->where('users.department_id', '=', $this->department)
    //                 ->where('users.name', 'LIKE', '%' . $this->search . '%')->get();
    //             return view('livewire.schedule.setSchedule', compact('users', 'departments'));
    //         } else if (auth()->user()->hasPermissionTo('setDepSchedule')) {
    //             $this->department = auth()->user()->department_id;
    //             $users = User::leftJoin('department', 'department.id', '=', 'users.department_id')
    //                 ->select('users.*', 'users.name as user_name', 'department.name as department_name')
    //                 ->where('users.status', '=', 1)
    //                 // ->where('users.department_id', '=', $this->department)
    //                 ->where('users.name', 'LIKE', '%' . $this->search . '%')->get();
    //             return view('livewire.schedule.setSchedule', compact('users'));
    //         } else {
    //             return view('404');
    //         }
    //     }
    // }
    public function render()
    {
        $companies = Company::all();
        $departments = Department::all();
        $users = User::where("status",1)->get();
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
                'off-day' => in_array($dayName,$this->offDay) == true ? 1 :null ,
            ]);
            $current_date->addDay(); // Move to the next day
        }
        return redirect()->route("schedule");
    }
}
