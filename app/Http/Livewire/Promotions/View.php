<?php

namespace App\Http\Livewire\Promotions;

use App\Models\Promotion;
use Livewire\Component;

class View extends Component
{
    public $promotion = '';
    public function mount($id)
    {
        $this->promotion = Promotion::leftjoin("company", "promotions.company_id", "company.id")
            ->leftjoin("department", "promotions.department_id", "department.id")
            ->leftjoin("users", "promotions.user_id","users.id")
            ->where("promotions.id", $id)
            ->select("users.name","promotions.part_time","promotions.from", "promotions.to", "promotions.position", "promotions.salary", "promotions.type", "company.name as company", "department.name as department")
            ->first();
    }
    public function render()
    {
        return view('livewire.Promotions.View',['promotion' => $this->promotion]);
    }
}
