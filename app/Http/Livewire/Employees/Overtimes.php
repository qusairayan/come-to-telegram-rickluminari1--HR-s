<?php

namespace App\Http\Livewire\Employees;

use App\Models\Overtime;
use App\Models\Allownce;
use Livewire\WithPagination;
use Livewire\Component;

class Overtimes extends Component
{
    use WithPagination;
    public $paginator = 10;
    public $search = '';
    public $overtimes;
    public $user_id;
    public $username = '';
    public $date = '';
    public $checkIn = '';
    public $checkOut = '';
    public $amount = 0;
    public $allownce = 0;
    public $overtimrID = 0;
    public $type;
    protected $rules = [
        'allownce' => 'required|numeric',
    ];
    public function viewAllownce($id)
    {
        $overtime = Overtime::leftjoin('users', 'users.id', '=', 'overtime.user_id')->leftjoin('department', 'department.id', '=', 'users.department_id')->leftjoin('attendence', 'attendence.id', '=', 'overtime.attendence_id')->select('overtime.*', 'users.name as user_name', 'users.id as user_id', 'attendence.date as date', 'attendence.check_in as checkin', 'attendence.check_out as checkout')->where('overtime.id', '=', $id)->first();
        $this->username = $overtime->user_name;
        $this->date = $overtime->date;
        $this->checkIn = $overtime->checkin;
        $this->checkOut = $overtime->checkout;
        $this->amount = $overtime->amount;
        $this->user_id = $overtime->user_id;
        $this->overtimrID = $id;
    }
    public function updated()
    {
        $this->validate([
            'allownce' => 'required|numeric'
        ]);
    }
    public function addAllownce()
    {
        $this->validate([
            'allownce' => 'required|numeric',
            'type' => 'required|numeric'
        ]);
        Allownce::create([
            'user_id' => $this->user_id,
            'date' => $this->date,
            'amount' => $this->amount,
            'type' => $this->type,
            'overtime' => $this->overtimrID,
        ]);
        $overtime = Overtime::findOrFail($this->overtimrID);
        $overtime->allownce = 1;
        $overtime->save();
        return redirect(route('employees.overtime'));
    }
    public function mount()
    {
        $this->overtimes = Overtime::leftJoin('users', 'overtime.user_id', '=', 'users.id')
            ->leftJoin('attendence', 'attendence.id', '=', 'overtime.attendence_id')
            ->leftJoin('department', 'department.id', '=', 'users.department_id')
            ->select('overtime.*', 'users.name as user_name', 'users.id as user_id', 'users.image as user_image', 'department.name as department_name', 'attendence.date as date')
            ->where('users.name', 'LIKE', '%' . $this->search . '%')
            ->get();
    }
    public function render()
    {
        return view('livewire.employees.overtime');
    }
}
