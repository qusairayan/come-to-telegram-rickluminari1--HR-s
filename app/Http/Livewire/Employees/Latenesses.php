<?php

namespace App\Http\Livewire\Employees;

use App\Models\deduction_allowances_types;
use App\Models\Lateness;
use App\Models\Deductions;
use Livewire\Component;
use Livewire\WithPagination;

class Latenesses extends Component
{
    use WithPagination;
    public $search = '';
    public $lateCheckIn = '';
    public $lateCheckOut = '';
    public $username = '';
    public $user_id = '';
    public $date = '';
    public $on = '';
    public $amount = 0;
    public $deduction = 0;
    public $lateId = 1;
    protected $rules = [
        'deduction' => 'required|numeric',
    ];
    public function viewDeduction($id)
    {
        $this->lateId = $id;
        $lsa = Lateness::leftJoin('attendence', 'attendence.id', '=', 'lateness.attendence_id')
            ->leftJoin('users', 'users.id', '=', 'lateness.user_id')
            ->select('lateness.*',  'attendence.date as date', 'attendence.check_in as check_in', 'users.name as username', 'users.id as user_id', 'attendence.check_out as check_out')
            ->where('lateness.id', '=', $this->lateId)->first();
        $this->lateCheckIn = $lsa->check_in;
        $this->lateCheckOut = $lsa->check_out;
        $this->date = $lsa->date;
        $this->on = $lsa->on;
        $this->amount = $lsa->amount;
        $this->username = $lsa->username;
        $this->user_id = $lsa->user_id;
    }
    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }
    public function addDeduction()
    {
        $this->validate([
            'deduction' => 'required|numeric'
        ]);
        $tt = deduction_allowances_types::find(7);
        $ded = Deductions::create([
            'user_id' => $this->user_id,
            'type' => 7,
            'amount' => $this->deduction,
            'date' => $this->date,
            'lateness' => $this->lateId,
        ]);
        $ded->detail = $tt->name;
        $ded->save();
        $lateness = Lateness::findOrFail($this->lateId);
        $lateness->deduction = 1;
        $lateness->save();
        return redirect(route('employees.lateness'));
    }
    public function render()
    {
        $lateness = Lateness::leftJoin('users', 'lateness.user_id', '=', 'users.id')
            ->leftJoin('attendence', 'attendence.id', '=', 'lateness.attendence_id')
            ->leftJoin('department', 'department.id', '=', 'users.department_id')
            ->select('lateness.*', 'users.name as user_name', 'users.id as user_id', 'users.image as user_image', 'department.name as department_name', 'attendence.date as date')
            ->where('users.name', 'LIKE', '%' . $this->search . '%')
            ->where('attendence.date', 'LIKE', '%' . $this->search . '%')
            ->paginate(10);
        return view('livewire.employees.lateness', ['lateness' => $lateness]);
    }
}
