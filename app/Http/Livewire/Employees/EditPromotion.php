<?php

namespace App\Http\Livewire\Employees;

use App\Models\Promotion;
use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;

class EditPromotion extends Component
{
    use WithPagination;
    public $search = '';
    public $company = '';
    public $department = '';
    public $user = '';
    public $user_id = '';
    public function render(Promotion $promotion)
    {
        $user_name = User::find($promotion->id)->name;
        $promotion->user_naem = $user_name;
        return view('livewire.employees.edit-promotion', ['promotion' => $promotion]);
    }
}
