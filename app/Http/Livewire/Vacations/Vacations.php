<?php

namespace App\Http\Livewire\Vacations;

use App\Models\Deductions;
use App\Models\Promotion;
use App\Models\User;
use App\Models\Vacation;
use Livewire\Component;
use Livewire\WithPagination;

class Vacations extends Component
{
    use WithPagination;
    public $search = '';
    public $perPage = 10;
    public $paginationView = 'vendor.pagination.custom';
    public $message = "";
    private $vacation = "";
    protected $listeners = ['messageUpdated'];
    public function updatedMessage($newMessage)
    {
        $this->emit('messageUpdated', $newMessage);
    }
    public function render()
    {
        $vacations = Vacation::leftJoin('users', 'vacations.user_id', '=', 'users.id')
            ->leftJoin('department', 'users.department_id', '=', 'department.id')
            ->select('vacations.*', 'users.name as user_name', 'department.name as department_name')
            ->where('users.name', 'LIKE', '%' . $this->search . '%')
            ->paginate($this->perPage);
        return view('livewire.vacations.vacations', compact('vacations'));
    }
    public function approve($id)
    {
        $vacation = Vacation::find($id);
        if ($vacation->status == 1) return;
        $user = User::where("id", "=", $vacation->user_id)->first();
        if ($vacation->type == 0) {
            if ($user->sick_vacation >= $vacation->period) $user->sick_vacation = $user->sick_vacation - $vacation->period;
            else {
                $this->vacation = $vacation;
                return $this->message = ["type" => 0, "msg" => "You do not have a balance of sick leave"];
            }
        } else {
            if ($user->annual_vacation >= $vacation->period) $user->annual_vacation = $user->annual_vacation - $vacation->period;
            else {
                $this->vacation = $vacation;
                return $this->message = ["type" => 0, "msg" => "You do not have a balance of annual leave"];
            }
        }
        $user->save();
        $vacation->status = 1;
        $vacation->save();
        return $this->message = ["type" => 1, "msg" => "vacation have been successfully granted"];
    }
    public function reject($id)
    {
        $vacation = Vacation::find($id);
        if ($vacation->status == 1) return $this->message = ["type" => 0, "msg" => "the vacation is acctuly approved"];
        $vacation->delete();
        return $this->message = ["type" => 1, "msg" => "deleted was successful!"];
    }
    public function click($vacation)
    {
        $salary = Promotion::where("user_id", $vacation['user_id'])->orderBy("from", "DESC")->pluck("salary")->first();
        if (!$salary) $salary = User::where("id", $vacation['user_id'])->pluck("salary")->first();
        $dedction =  Deductions::create([
            "user_id" => $vacation['user_id'],
            "type" => 2,
            "amount" => (int) $salary / 30,
            "date" => date("Y-m-d"),
            "status" => 0,
            "detail" => "vacation"
        ]);
        if ($dedction) {
            $vacation = Vacation::find($vacation["id"]);
            $vacation->status = 1;
            $vacation->credit = 1;
            $vacation->save();
            return  $this->message = ["type" => 1, "msg" => "dedction was successful!"];
        } else return $this->message = ["type" => 0, "msg" => "The operation failed!"];
    }
}
