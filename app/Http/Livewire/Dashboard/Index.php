<?php

namespace App\Http\Livewire\Dashboard;

use App\Models\User;
use DateTime;
use Livewire\Component;

class Index extends Component
{
    public function render()
    {
        $users = User::join("company", "users.company_id", "company.id")
            ->leftJoin("attendence", function ($join) {
                $join->on("users.id", "attendence.user_id")
                    ->where("date", date("Y-m-d"));
            })->leftJoin("employees_contracts", function ($join) {
                $join->on("users.id", "employees_contracts.user_id");
            })
            ->whereNotNull("attendence.check_in")->where("users.status", 1)->orderBy("id", "DESC")->select("users.*", "company.name as company", "attendence.check_in", "employees_contracts.date as contract")->get();
        $activeUser = User::join("company", "users.company_id", "company.id")
            ->leftJoin("employees_contracts", function ($join) {
                $join->on("users.id", "employees_contracts.user_id");
            })
            ->where("users.status", 1)->orderBy("id", "DESC")->select("users.*", "company.name as company", "employees_contracts.date as contract")->get();
        $activeUser = $activeUser->map(function ($user) {
            $time = new DateTime();
            if ($user->contract) {
                if ($user->Duration_contract) $user->expire_contract =  date("Y-m-d", strtotime(date("Y-m-d", strtotime($user->contract)) . " + 1 year"));
                else $user->expire_contract =  date("Y-m-d", strtotime(date("Y-m-d", strtotime($user->contract)) . " + " . $user->Duration_contract . "3 month"));
            }
            return $user;
        });
        return view('dashboard', compact("users", "activeUser"));
    }
}
