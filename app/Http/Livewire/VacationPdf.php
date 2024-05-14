<?php

namespace App\Http\Livewire;

use App\Models\User;
use App\Models\Vacation;
use Carbon\Carbon;
use Livewire\Component;
use Mpdf\Mpdf;

class VacationPdf extends Component
{
    public $user = "";
    public $date = "";
    public function mount($id, $date)
    {
        $this->date = explode("-", $date)[0];
        $this->user = User::find($id);
        $this->user->department = $this->user->department->name;
        $this->user->company = $this->user->company->name;
    }
    public function render()
    {
        $id = $this->user->id;
        $vacations = Vacation::where("user_id", $id)->where("credit", 0)->where("status", 1)->where("date", "LIKE", $this->date . "-%")->orderBy("date", 'DESC')->get();
        $vacations = $vacations->map(function ($vacation) {
            if ($vacation->period > 1) {
                $carbonDate = Carbon::parse($vacation->date);
                $vacation->endDate = $carbonDate->addDays(2)->format("Y-m-d");
                return $vacation;
            }
        });
        $mpdf = new Mpdf([
            'mode' => 'utf-8',
            'format' => 'A4-L',
            'margin_left' => 10,
            'margin_right' => 10,
            'margin_top' => 10,
            'margin_bottom' => 10,
        ]);
        $mpdf->WriteHTML(view('livewire.vacation-pdf', ["vacations" => $vacations, "user" => $this->user, "date" => $this->date]));
        $mpdf->Output('document.pdf', 'I');
    }
}
