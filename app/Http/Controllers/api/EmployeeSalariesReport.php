<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Company;
use App\Models\MonthlyPayroll;
use App\Models\User;
use Hamcrest\Arrays\IsArray;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class EmployeeSalariesReport extends Controller
{
    public function index(Request $request)
    {
        $compId = Company::where("name", $request->companyName)->pluck("id");
        $users = User::where("company_id", $compId)
            ->join("monthly_payrolls", "monthly_payrolls.user_id", "users.id")
            ->select(
                "users.id",
                "users.name",
                "monthly_payrolls.salary",
                "monthly_payrolls.month",
            )
            ->orderBy("monthly_payrolls.month", "asc")
            ->whereBetween("month", [$request->date1, $request->date2])
            ->get();
        $checkTable = null;
        $imageCompany = null;
        switch ($request->companyName) {
            case 'Lyon Travel':
                $checkTable = 'check_lyon';
                $imageCompany = 'lyontravell.png';
                break;
            case 'Lyon Rental Car':
                $checkTable = 'check_lyon';
                $imageCompany = 'lyonrental.png';
                break;
            default:
                $checkTable = 'check_marvell';
                $imageCompany = 'marvellLogo.png';
                break;
        }
        $checks = DB::connection('LYONDB')
            ->table($checkTable)
            ->Where('Payment_For', 'like', "%" . "Employee". '%')
            ->Where('Name_To', 'like',"مروان محمود عطيه محمد")
            ->whereBetween("Date", [$request->date1, $request->date2])
            ->orderBy("Date","asc")->orderBy("NAME_TO")
            ->select("Value as month","Name_To","Date","id")
            ->get();
        // $checkForPreBalance = DB::connection('LYONDB')->table($checkTable)->whereBetween("Date", [$request->date1, $request->date2])->sum("Value");
        $monthlyPayrollsForPreBalance = MonthlyPayroll::where("month", "<" , "$request->date1")->sum("salarys");

            // foreach ($users as $key => $user) {
            //     $checkss = array();
            //     foreach ($checks as $key => $check) {
            //         if ($user->name == $check) {
            //             array_push($checkss, $check);
            //         }
            //     }
            // }
        return response()->json(["data" => $monthlyPayrollsForPreBalance]);
    }
}
