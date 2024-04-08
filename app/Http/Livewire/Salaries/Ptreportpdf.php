<?php

namespace App\Http\Livewire\Salaries;

use App\Models\Allownce;
use App\Models\Company;
use App\Models\Deductions;
use App\Models\Department;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Livewire\Component;
use App\Models\PartTime;
use App\Models\Promotion;
use App\Models\User;
use Mpdf\Mpdf;
use stdClass;

use function PHPSTORM_META\map;

class Ptreportpdf extends Component
{
    public $user;
    private $partTime;
    private $checks;
    private $dedction;
    private $allownce;
    public $checkComp;
    public $image;
    public $reBalance;
    public $pending;
    public function generatePDF($id, $from, $to)
    {
        // $this->validate([
        //     'id' => 'required',
        //     'from' => 'required|date',
        //     'to' => 'required|date',
        // ]);
        $from = $from . "-01";
        $to = $to . "-31";
        $this->getDate($id, $from, $to);
        $this->reBalance = $this->reBalance($from, $to);
        $checks = [];
        if ($this->checks) {
            for ($i = 0; $i < count($this->checks); $i++) {
                $checks[$i] = (array) $this->checks[$i];
                $checks[$i]["type"] = "check";
            }
        }
        if ($this->dedction) {
            for ($i = 0; $i < count($this->dedction); $i++) {
                $this->dedction[$i] = (array) $this->dedction[$i];
                $this->dedction[$i]["name"] = $this->dedction[$i]["type"];
                $this->dedction[$i]["type"] = "dedction";
            }
        }
        if ($this->allownce) {
            for ($i = 0; $i < count($this->allownce); $i++) {
                $this->allownce[$i] = (array) $this->allownce[$i];
                $this->allownce[$i]["name"] = $this->allownce[$i]["type"];
                $this->allownce[$i]["type"] = "allownce";
            }
        }
        if ($this->partTime) {
            for ($i = 0; $i < count($this->partTime); $i++) {
                $this->partTime[$i] = (array) $this->partTime[$i];
                $this->partTime[$i]["type"] = "salary";
            }
        }
        $data = array_merge($checks, $this->dedction, $this->allownce, $this->partTime);
        $date = array_column($data, 'date');
        array_multisort($date, SORT_ASC, $data);
        $mpdf = new Mpdf([
            'mode' => 'utf-8',
            'format' => 'A4-L',
            'margin_left' => 10,
            'margin_right' => 10,
            'margin_top' => 10,
            'margin_bottom' => 10,
        ]);
        $mpdf->WriteHTML(view('livewire.salaries.partTimeReport',  ["pending" => $this->pending, "data" => $data, "reBalance" => $this->reBalance, "user" => $this->user, 'partTime' => $this->partTime, 'from' => $from, 'to' => $to, "image" => $this->image]));
        $mpdf->Output('document.pdf', 'I');
    }
    private function reBalance($from, $to)
    {
        $sum = PartTime::where('user_id', $this->user['id'])->where('from', "<", $from)->sum("amount");
        $sum += Allownce::where("user_id", $this->user['id'])->where('Date', "<", $from)->sum("amount");
        $sum -= Deductions::where("user_id", $this->user['id'])->where('Date', "<", $from)->sum("amount");
        $sum -= DB::connection('LYONDB')->table($this->checkComp)
        // ->where('Name_To', 'LIKE', '%' . $this->user["name"] . '%')
        ->where("employee_id",$this->user["id"])
        ->where('Date', "<", $from)->sum("Value");
        return $sum;
    }
    private function getDate($id, $from, $to)
    {
        $this->user = User::where('id', $id)->first();
        // get promotion
        $promotion = Promotion::where("user_id", $id)
            ->where('from', '>=', $from)
            ->where(function ($query) use ($to) {
                $query->where('to', '<=', $to)
                    ->orWhereNull('to');
            })
            ->first();
        if ($promotion) {
            $this->user["salary"] = $promotion->salary;
            $this->user["company"] = Company::where("id", $promotion->company_id)->pluck("name")->first();
            $this->user["department"] = Department::where("id", $promotion->department_id)->pluck("name")->first();
        } else {
            $this->user->company;
            $this->user->department->name;
            $this->user = $this->user->toArray();
            $this->user["company"] = $this->user["company"]["name"];
            $this->user["department"] = $this->user["department"]["name"];
        }
        if ($this->user["company"] == 'Lyon Travel') {
            $this->checkComp = 'check_lyon';
            $this->image = 'lyontravell.png';
        } elseif ($this->user["company"] == 'Lyon Rental Car') {
            $this->checkComp = 'check_lyon_rental';
            $this->image = 'lyonrental.png';
        } else {
            $this->checkComp = 'check_marvell';
            $this->image = 'marvellLogo.png';
        }
        // get parttime
        $this->partTime = PartTime::where('user_id', $this->user['id'])->where('from', ">=", $from)->where("to", "<=", $to)->select("part_times.*", "from as date")->get()->toArray();
        $this->pending = PartTime::where('user_id', $this->user['id'])->where('from', ">=", $from)->where("status", 0)->select("part_times.*", "from as date")->get()->toArray();
        $this->checks = DB::connection('LYONDB')->table($this->checkComp)
        // ->where('Name_To', 'LIKE', "%" . $this->user["name"] . "%")
        ->where('employee_id',$this->user['id'])
        ->whereBetween('Date', [$from, $to])->orderBy("date")->select("$this->checkComp.*", "Date as date")->get()->toArray();
        $this->dedction = Deductions::where("user_id", $this->user['id'])->where("status",1)->whereBetween('Date', [$from, $to])->orderBy("date")->get()->toArray();
        $this->allownce = Allownce::where("user_id", $this->user['id'])->where("status",1)->whereBetween('Date', [$from, $to])->orderBy("date")->get()->toArray();
    }
}
