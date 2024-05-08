<?php

namespace App\Http\Livewire\Employees;

use App\Models\Company;
use App\Models\Department;
use App\Models\Promotion;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class EditPromotion extends Component
{
    public $company = '';
    public $department = '';
    public $to = '';
    public $from = '';
    public $position = '';
    public $salary = '';
    public $type = '';
    public $name = '';
    public $promoId = '';
    public $part_time = '';
    public function mount($id)
    {
        $this->promoId   = $id;
        $promotion = Promotion::leftjoin("company", "promotions.company_id", "company.id")
            ->leftjoin("department", "promotions.department_id", "department.id")
            ->leftjoin("users", "promotions.user_id","users.id")
            ->where("promotions.id", $id)
            ->select("users.name","promotions.department_id","promotions.company_id", "promotions.from", "promotions.to", "promotions.position", "promotions.salary", "promotions.type", "company.name as company", "department.name as department")
            ->first();
        $this->name = $promotion->name;
        $this->company = $promotion->company_id;
        $this->department = $promotion->department_id;
        $this->from = $promotion->from;
        $this->to = $promotion->to;
        $this->position = $promotion->position;
        $this->salary = $promotion->salary;
        $this->type = $promotion->type;
    }
    public function render()
    {
        $companies = Company::get();
        $departments = Department::get();
        return view('livewire.employees.edit-promotion', ["companies"=>$companies,"departments"=>$departments]);
    }
    public function update()
    {
        $promotion = Promotion::find($this->promoId);
        if ($promotion) {
            $type = $this->part_time !== "" ? 0 : 1;
            $promotion->update([
                'company_id' => $this->company,
                'department_id' => $this->department,
                'to' => $this->to,
                'position' => $this->position,
                'salary' => $this->salary,
                'type' => $this->type,
                'part_time'=>$this->part_time
            ]);
            return redirect(route('promotions'));
        }
    }
}
