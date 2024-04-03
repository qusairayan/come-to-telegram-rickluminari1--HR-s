<?php



namespace App\Http\Livewire\Deductions;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

use App\Models\Deductions;
use App\Models\TrafficViolations;
use App\Models\Allownce;
use App\Models\deduction_allowances_types;
use App\Models\User;
use Livewire\WithPagination;

use Livewire\Component;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class DeductionsController extends Component
{
    use WithPagination;

    public $amount;
    public $userId;
    public $date;
    public $type;
    public $paginator = 10;
    public $search = '';
    public $employee = '';
    public $from = '';
    public $to = '';
    public $department = '';
    public $typeDeduction = '';


    protected $rules = [
        'amount' => 'required|numeric',
        'userId' => 'required|numeric',
        'date' => 'required|date',
        'type' => 'required|string',
    ];





    public function approveTrafic($deduction)
    {
        Deductions::create([
            "user_id" => $deduction['user_id'],
            "type" => 1,
            "amount" => $deduction['amount'],
            "date" => $deduction['date'],
            "detail" => $deduction['violation_reason'],
            "status" => 1,
        ]);
        $deduction = TrafficViolations::find($deduction["id"]);
        $deduction->status = 1;
        $deduction->save();
    }
    public function approve($deductionId, $i)
    {
        $deduction = Deductions::findOrFail($deductionId);
        $deduction->status = 1;
        $deduction->save();
    }

    public function render()
    {
        $users = User::all()->where('status', '=', 1);

        $violations = TrafficViolations::where("status", 0)->get();


        $deductions = Deductions::leftJoin("users", function ($join) {
            $join->on("users.id", "=", "deductions.user_id")
                ->leftJoin("department", "department.id", "=", "users.department_id");
        })
            ->where('users.name', 'LIKE', '%' . $this->search . '%')
            ->orderBy("deductions.date", "desc")
            ->select('deductions.*', 'users.name', 'users.department_id', 'users.company_id', 'department.name as department')
            ->paginate(50);
        $types = deduction_allowances_types::where("type", 0)->get();
        return view('livewire.deductions.deductions', compact('deductions', "types", "users", "violations"));
    }
    public function addDeduction()
    {
        $err = $this->validate();
        Deductions::create([
            "user_id" => $this->userId,
            "amount" => $this->amount,
            "date" => $this->date,
            "type" => $this->type,
        ]);
        return redirect("deductions");
    }
    public function addTypeDeduction()
    {
        $this->rules = [
            'typeDeduction' => "required|string|min:3|max:255|unique:deduction_allowances_types,name",
        ];
        $this->validate();
        deduction_allowances_types::create([
            'type' => false,
            "name" => $this->typeDeduction,
        ]);
        return redirect()->route("deductions");
    }
    public function delete($id)
    {
        Deductions::destroy($id);
        return redirect()->route("deductions");
    }
}
