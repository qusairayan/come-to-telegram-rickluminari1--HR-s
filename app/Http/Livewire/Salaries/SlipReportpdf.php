<?php

namespace App\Http\Livewire\Salaries;

use App\Models\Allownce;
use App\Models\Company;
use App\Models\deduction_allowances_types;
use App\Models\Deductions;
use App\Models\Department;
use App\Models\MonthlyPayroll;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Livewire\Component;
use App\Models\PartTime;
use App\Models\Promotion;
use App\Models\Salary;
use App\Models\SocialSecurity;
use App\Models\User;
use Carbon\Carbon;
use DateTime;
use Mpdf\Mpdf;
use PhpParser\Node\Stmt\Return_;

class SlipReportpdf extends Component
{
    public $user;
    public function generatePDF($id)
    {
        $res = MonthlyPayroll::find($id);
        $userId = $res->user_id;
        $id = $userId;
        $month = explode("-", $res->month);
        $date = $month[0] . '-' . $month[1];
        // $this->getUser($id, $date);
        $this->user = User::where("id", $id)->first();
        $this->user->company;
        $this->user->department->name;
        $this->user = $this->user->toArray();
        $this->user["company"] = $this->user["company"]["name"];
        $this->user["department"] = $this->user["department"]["name"];
        // $promotion = Promotion::where("user_id", $this->user["id"])->orderBy("from", "desc")->where("from","<=",$date."-01")->first();
        $promotion = Promotion::where("user_id", $this->user["id"])->where('from', '<=', $date . "-01")->where(function ($query) use ($date) {
            $query->where('to', '>=', $date . "-01")->orWhereNull("to");
        })->first();
        if ($promotion) {
            $this->user["salary"] = $promotion->salary;
            $this->user["company"] = Company::where("id", $promotion->company_id)->pluck("name")->first();
            $this->user["department"] = Department::where("id", $promotion->department_id)->pluck("name")->first();
        }
        $this->IdentifyCompany();
        $deduction = Deductions::where("date", "LIKE", $date . "-%")->where("user_id", $id)->where("status", 1)->get()->toArray();
        $userSalary = $this->user["salary"];
        $user = User::where("id", $this->user)->select("salary", "start_date", "unemployment_date")->get()->toArray();
        if ($user[0]["unemployment_date"]) $unemployment = Carbon::parse($user[0]["unemployment_date"]);
        else $unemployment = null;
        $startDate = Carbon::parse($user[0]["start_date"]);
        if ($unemployment && $unemployment->format("Y-m") == $date) {
            $monthdays = 30;
            if (explode("-", $date)[1] == 2) {
                $monthdays  = date("t") - 1;
            }
            $countDays = (int) $unemployment->format("d");
            if ($unemployment->format("Y-m")  == $startDate->format("Y-m")) {
                $countDays =  (int) $unemployment->format("d") - (int) $startDate->format("d") + 1;
            }
            $salaryPerDay = $userSalary / $monthdays;
            $userSalary = $salaryPerDay * $countDays;
            $userSalary = number_format($userSalary, 2, ".", " ");
        } elseif ($startDate->format("Y-m") === $date) {
            $countDays  = 31;
            if (explode("-", $date)[1] == 2) {
                $countDays  = $startDate->format("t");
                $countDays++;
            }
            $countDays = $countDays - $startDate->format("d");
            $salaryPerDay = $userSalary / 30;
            $userSalary = $salaryPerDay * $countDays;
            $userSalary = number_format($userSalary, 2, ".", " ");
        }
        $names = array_column($deduction, "type");
        $deductionTypes = deduction_allowances_types::where("type", 0)->whereNotIn("name", $names)->get()->toArray();
        $allownce = Allownce::where("date", "LIKE", $date . "-%")->where("user_id", $id)->where("status", 1)->get()->toArray();
        $names = array_column($allownce, "type");
        $allownceTypes = deduction_allowances_types::where("type", 1)->whereNotIn("name", $names)->get()->toArray();
        $checks = DB::connection('LYONDB')
            ->table($this->user["checkComp"])
            ->where('NAME_TO', $this->user["name"])
            ->where("date", "LIKE", $date . "-%")
            ->select("Payment_Method", "Value", "Date", "check_details")
            ->get()->toArray();
        $currentDate = date("Y-m");
        $dateTime = new DateTime($currentDate);
        $dateTime->modify("-1 month");
        $newDate = $dateTime->format("Y-m");
        $monthly_payroll = MonthlyPayroll::where("month", "=", $date . "-01")->where("user_id", $this->user["id"])->pluck("salary")->first();
        // $this->user["salary"] = $monthly_payroll ?? $promotion ?? $this->user["salary"];
        $social = SocialSecurity::where("date", "Like", date($date) . "-%")->where("user_id", $id)->pluck("onEmployee")->first();
        $this->user["SocialSecurity"] = $social;
        $this->runPdf('livewire.salaries.SlipReport', ["userSalary" => $userSalary, "monthly_payroll" => $monthly_payroll, "social" => $social, "user" => $this->user, "allownce" => $allownce, "deduction" => $deduction, 'checks' => $checks, 'date' => $date, "deductionTypes" => $deductionTypes, "allownceTypes" => $allownceTypes]);
    }
    public function FullTimegeneratePDF($id, $from, $to)
    {
        $this->getUser($id . null, $from, $to);
        $check = DB::connection('LYONDB')
        ->table($this->user["checkComp"])
        // ->where('NAME_TO', $this->user["name"])
        ->orWhere('NAME_TO', 'like', '%' . $this->user["name"] . '%')
        ->where("Date",">=", $from."-01")->where("Date","<=", $to."-01")
        ->orderBy("Date")
        ->select("Payment_Method", "Value", "Date as month", "check_details")
        ->get()->toArray();
        // dd($check);
        $preBalance = $this->PreBalance($from . "-01");
        $salaries = $this->calcSalary($from . "-01", $to . "-01");
        $arr = array_merge($salaries, $check);
        $months = array_column($arr, 'month');
        array_multisort($months, SORT_ASC, $arr);
        $this->runPdf('livewire.salaries.full-time-report', ["user" => $this->user, "arr" => $arr, "preBalance" => $preBalance, 'from' => $from, "to" => $to]);
    }
    private function runPdf(string $view, array $arr): void
    {
        $mpdf = new Mpdf([
            'mode' => 'utf-8',
            // 'format' => 'A6-L',
            'format' => [280, 436],
            'margin_left' => 10,
            'margin_right' => 10,
            'margin_top' => 10,
            'margin_bottom' => 10,
        ]);
        $mpdf->WriteHTML(view($view, $arr));
        $mpdf->showImageErrors = true;
        $mpdf->Output('document.pdf', 'I');
        exit;
    }
    private function getUser($id, $date = null, $from = null, $to = null)
    {
        $this->user = User::where("id", $id)->first();
        $this->user->company;
        $this->user->department->name;
        $this->user = $this->user->toArray();
        $this->user["company"] = $this->user["company"]["name"];
        $this->user["department"] = $this->user["department"]["name"];
        $promotion = Promotion::where("user_id", $this->user["id"])
            ->where('from', '>=', $from . "-01")
            ->where(function ($query) use ($to) {
                $query->where('to', '<=', $to . "-01")
                    ->orWhereNull('to');
            })
            ->first();
        if ($promotion) {
            $this->user["salary"] = $promotion->salary;
            $this->user["company"] = Company::where("id", $promotion->company_id)->pluck("name")->first();
            $this->user["department"] = Department::where("id", $promotion->department_id)->pluck("name")->first();
        }
        // if (!$date) {
        //     $promotion = Promotion::where("user_id", $this->user["id"])->orderBy("from", "desc")->pluck("salary")->first();
        //     if ($promotion) $this->user["salary"] = $promotion;
        // }
        return $this->IdentifyCompany();
    }
    private function IdentifyCompany()
    {
        // based promotion
        switch ($this->user['company']) {
            case 'Lyon Travel':
                $this->user['checkComp'] = 'check_lyon';
                $this->user['image'] = 'lyontravell.png';
                break;
            case 'Lyon Rental Car':
                $this->user['checkComp'] = 'check_lyon';
                $this->user['image'] = 'lyonrental.png';
                break;
            default:
                $this->user['checkComp'] = 'check_marvell';
                $this->user['image'] = 'marvellLogo.png';
                break;
        }
        return $this->getSocialSecurity();
    }
    private function getSocialSecurity()
    {
        try {
            $test = SocialSecurity::where("user_id", $this->user["id"])->first();
            $this->user["SocialSecurity"] = $test->onEmployee;
        } catch (\Throwable $th) {
            $this->user["SocialSecurity"] = 0;
        }
    }
    private function getChecks(string $from, $to = NULL)
    {
        if (!$to) {
            $checks = DB::connection('LYONDB')
                ->table($this->user["checkComp"])
                ->where('NAME_TO', $this->user["name"])
                ->orWhere('NAME_TO', 'like', '%' . $this->user["name"] . '%')
                ->whereBetween("date", [$from, $to])
                ->orderBy("date")
                ->select("Payment_Method", "Value", "Date", "check_details")
                ->get()->toArray();
        } else {
            $from = substr($from, 0, 7);
            $from = $from . "-30";
            dd($from);
            $checks = DB::connection('LYONDB')
                ->table($this->user["checkComp"])
                ->where("Date", ">=", $from)
                ->where('NAME_TO', $this->user["name"])
                ->orWhere('NAME_TO', 'like', "%-" . $this->user["name"] . '-%')->select("*", "Date as month")
                ->get()->toArray();
        }
        return $checks;
    }
    private function getDeductions(string $from, $to = NULL)
    {
        if (!$to) return Deductions::where('user_id', $this->user['id'])->where("status", 1)->where("date", ">=", $from)->orderBy("date")->get()->toArray();
        return Deductions::where('user_id', $this->user['id'])->where("status", 1)->whereBetween("date", [$from, $to])->get()->toArray();
    }
    private function getAllownce(string $from, $to = NULL)
    {
        if (!$to) return Allownce::where('user_id', $this->user['id'])->where("status", 1)->where("date", ">=", $from)->orderBy("date")->get()->toArray();
        return Allownce::where('user_id', '=', $this->user['id'])->where("status", 1)->whereBetween("date", [$from, $to])->get()->toArray();
    }
    private function PreBalance($from)
    {
        $sum = DB::connection('LYONDB')
            ->table($this->user["checkComp"])
            ->where("Date", "<=", $from)
            ->where('NAME_TO', $this->user["name"])
            ->orWhere('NAME_TO', 'like', "%-" . $this->user["name"] . '-%')
            ->whereBetween('Date', [$this->user["start_date"], $from])
            ->sum("Value");
        $start_date = Carbon::parse($from);
        $current_date = $start_date->copy();
        $current_date->subDay();
        $sum -= MonthlyPayroll::where("user_id", $this->user["id"])->whereBetween("month", [$this->user["start_date"], $current_date])->sum("salary");
        $sum = abs($sum);
        return $sum;
    }
    private function calcSalary($from, $to)
    {
        $salaries = MonthlyPayroll::where("user_id", $this->user["id"])->whereBetween("month", [$from, $to])->select("salary", "month")->orderBy("month", "asc")->get()->toArray();
        return $salaries;
    }
}
