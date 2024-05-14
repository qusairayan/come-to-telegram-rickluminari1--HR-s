<?php

namespace App\Http\Livewire\Banks;

use App\Models\Bank;
use Livewire\Component;

class Index extends Component
{
    public string $bankName;
    public function render()
    {
        $banks = Bank::latest()->paginate(10);
        return view('livewire.Banks.Index', ["banks" => $banks]);
    }
    public function create()
    {
        $this->validate(["bankName" => "required|string|min:3|max:50"]);
        Bank::create(["name" => $this->bankName]);
    }
}
