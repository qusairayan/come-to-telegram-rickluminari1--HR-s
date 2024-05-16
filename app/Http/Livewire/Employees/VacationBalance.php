<?php

namespace App\Http\Livewire\Employees;

use App\Models\Company;
use App\Models\Department;
use App\Models\User;
use App\Models\Vacation;
use Carbon\Carbon;
use Livewire\Component;
use Mpdf\Mpdf;

class VacationBalance extends Component
{
    public $search ="";
    public $message = "";
    public $employee = "";
    public $date = "";
    public function render(){
        $users = User::where("status",1)->where("Duration_contract",1)->get();
        if($this->search)$users = User::where("name", "LIKE", $this->search . "%")->where("status",1)->where("Duration_contract",1)->get();
        if($this->employee)$users = User::where("id",$this->employee)->get();
        return view('livewire.Employees.vacation-balance',["users"=>$users]);
    }
    public function addVacation($id){
        $user = User::find($id);
        if(!$user->sick_vacation && !$user->annual_vacation){
            $startWork = Carbon::parse($user->start_date);
            if($startWork->format("y") == date(("y")) && $startWork->format("m") < 12 && $startWork->format("m") > 1){
                $month =12 -  $startWork->format("m");
                $user->sick_vacation = floor(1.16 * $month) ;
                $user->annual_vacation = floor(1.16 * $month);
            }else{
                $user->sick_vacation  = 14;
                $user->annual_vacation = 14;
            }
            $user->save();
            return $this->message = ["type"=>1,'msg'=>"The vacation balance has been added to employee ".$user->name];
        }else{
            return $this->message = ["type"=>0,'msg'=>"Employee already has vacations ".$user->name];
        }
    }
    public function resetVacation($id){
        if(date('z') === 0){
            $user = User::find($id);
            $user->sick_vacation = 14;
            $user->annual_vacation = 14;
            $user->save();
            return $this->message = ["type"=>1,'msg'=>"The employee's vacations have been reset for".$user->name];
        }
        else return $this->message = ["type"=>0,'msg'=>"Vacations are reset every beginning of the year"];
    }
    function validDate($id){
        $err =  $this->validate([
            "date"=>"required|date",
        ]);
        return redirect()->route("vacations.report",[$id,$this->date]);
    }
}
