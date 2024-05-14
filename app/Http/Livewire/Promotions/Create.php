<?php

namespace App\Http\Livewire\Promotions;

use App\Models\Company;
use App\Models\User;
use App\Models\Promotion;
use App\Models\Department;
use Livewire\Component;
use Livewire\WithPagination;


class Create extends Component
{
    use WithPagination;
    public $company;
    public $type;
    public $department;
    public $user;
    public $salary = '';
    public $from = '';
    public $end = '';
    public $position = '';
    public $part_time = '';
    protected $rules = [
        'company' => 'required|numeric|exists:company,id',
        'department' => 'required|numeric|exists:department,id',
        'user' => 'required|numeric|exists:users,id',
        'salary' => 'required|numeric',
        'from' => 'required|date',
        'end' => 'date',
        'position' => 'required',
    ];
    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }
    public function create()
    {
        $this->validate([
            'company' => 'required|numeric|exists:company,id',
            'department' => 'required|numeric|exists:department,id',
            'user' => 'required|numeric|exists:users,id',
            'salary' => 'required|numeric',
            'from' => 'required|date',
            'end' => 'date',
            'position' => 'required',
        ]);
        $prevPromo = Promotion::where('user_id', $this->user)->where('from', '<', $this->from)->orderBy('from', 'desc')->first();
        if ($prevPromo) {
            $prevPromo->to = $this->from;
            $prevPromo->save();
        }

        $type = $this->part_time !== "" ? 0 : 1;
        $promotion = Promotion::create([
            'user_id' => $this->user,
            'department_id' => $this->department,
            'company_id' => $this->company,
            'salary' => $this->salary,
            'type' => $type,
            'from' => $this->from,
            'position' => $this->position,
            'part_time' => $this->part_time
        ]);
        $promotion->save();
        return redirect(route('promotions'));
    }
    public function render()
    {
        $companies = Company::all();
        $departments = Department::Where('company_id', '=', $this->company)->get();
        // $users = User::Where('department_id', '=', $this->department)->get();
        $users = User::all();
        return view('livewire.Promotions.Create', ['companies' => $companies, 'departments' => $departments, 'users' => $users]);
    }
}
