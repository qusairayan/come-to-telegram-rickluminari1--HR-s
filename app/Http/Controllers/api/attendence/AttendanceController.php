<?php

namespace App\Http\Controllers\api\attendence;

use App\Http\Controllers\api\Leave\LeaveController;
use App\Http\Controllers\Controller;
use App\Http\Requests\Attendedence\Api\CreateAttendenceRequest;
use App\Models\Attendence;
use App\Models\Lateness;
use App\Models\Leave;
use App\Models\Overtime;
use App\Models\Schedule;
use App\Models\Schedules;
use App\Models\User;
use Carbon\Carbon;
use DateInterval;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AttendanceController extends Controller
{
    private $day, $time, $user;
    public function __construct()
    {
        $this->day = Carbon::today("Asia/Amman")->isoFormat("YYYY-MM-DD");
        $this->time = Carbon::now("Asia/Amman");
    }
    public function create(CreateAttendenceRequest $request)
    {
        $request->validated();
        $this->user = Auth::user();
        $attendance = Attendence::where("user_id", $this->user->id)->where("date", date("Y-m-d"))->first();
        $leave = Leave::where("user_id", $this->user->id)->where("date", date("Y-m-d"))->where('status', '=', 1)->first();
        if ($request->type == 0) { //checkin
            if ($attendance) return response()->json(["success" => false, "message" => "You have already checked-in for today"], 400);
            if (!$leave || !$leave->checkin) { //checkin
                $attendance =
                    Attendence::create([
                        "type" => 0,
                        "user_id" => $this->user->id,
                        "date" => $this->day,
                        "check_in" => $this->time,
                        "location_id" => $request->location
                    ]);
                $timeDifference = $this->timeDifference("checkIn");
                if ($timeDifference) {
                    if ($timeDifference > 5) $this->late($attendance, "checkIn", $timeDifference);
                }
                return response()->json(["success" => true, "message" => "checked-in successfully"], 201);
            } else {
                if (!$leave->checkout) { //checkout leave then checkin attendance
                    $leave->checkout = $this->time;
                    $leave->save();
                    $status = new LeaveController();
                    $status->checkoutt($leave);
                    $attendance = Attendence::create([
                        "type" => 0,
                        "user_id" => $this->user->id,
                        "date" => $this->day,
                        "check_in" => $this->time,
                        "location_id" => $request->location
                    ]);
                    $timeDifference = $this->timeDifference("checkIn");
                    if (!$timeDifference) $timeDifference = 0;
                    Lateness::create([
                        "user_id" => $this->user->id,
                        "attendence_id" => $attendance->id,
                        "amount" => $timeDifference,
                        "on" => "checkIn",
                        "detailes" => "leave on time " . $this->time->format("Y-m-d H:i:s")
                    ]);
                    return response()->json(["success" => true, "message" => "checked-in successfully"], 201);
                }
            }
        } else { //checkout
            if (!$attendance || $attendance?->check_out) return response()->json(["success" => false, "message" => "You have already checked-out for today"], 400);
            if ($leave && !$leave->checkin) return response()->json(["success" => false, "message" => "You cannot check out before leave"], 400);
            if ($leave && !$leave->checkout) {
                $status = new LeaveController();
                $status->checkoutt($leave);
            }
            $attendance->check_out = $this->time;
            $locations = [$attendance->location_id];
            $locations[] = $request->location;
            $attendance->location_id = json_encode($locations);
            $attendance->save();
            $timeDifference = $this->timeDifference("checkOut");
            if ($timeDifference) {
                if ($timeDifference > 6) $this->late($attendance, "checkOut", $timeDifference);
                elseif ($timeDifference <= 30) $this->overTime($attendance);
            }
            return response()->json(["success" => true, "message" => "checked-out successfully"], 201);
        }
    }
    private function timeDifference($on, $time = NULL): string
    {
        if (!$time) $time = $this->time;
        $scheduale = Schedules::where("date", $this->day)->where("user_id", $this->user->id)->first();
        if ($scheduale) {
            if ($on == "checkIn") return $time->diffInMinutes($scheduale->from);
            else return $time->diffInMinutes($scheduale->to);
        } else return false;
    }
    private function late($attendece, $on, $timeDifference)
    {
        Lateness::create([
            "user_id" => $this->user->id,
            "attendence_id" => $attendece->id,
            "amount" => $timeDifference,
            "on" => $on
        ]);
    }
    public function overTime($attendece)
    {
        Overtime::create([
            "amount" => $this->time,
            "attendence_id" => $attendece->id,
            "user_id" => $this->user->id,
        ]);
    }
    public function AttendenceToday()
    {
        $user = Auth::user();
        $data = Attendence::where("user_id", $user->id)->where("date", date("Y-m-d"))->select("date", "check_in", "check_out")->first();
        if (!$data) return response()->json(["success" => true, "data" => 0], 200);
        if ($data->check_in && $data->check_out) return response()->json(["success" => true, "data" => 2], 200);
        if ($data->check_in) return response()->json(["success" => true, "data" => 1], 200);
    }
    public function recordApi(Request $request)
    {
        $id = $request->input("id");
        $attendanceList = Attendence::leftJoin("leaves", "attendence.date", "=", "leaves.date")
            ->select(
                "attendence.date as attendence_date",
                "attendence.check_in as check_in",
                "attendence.check_out as check_out",
                "leaves.date as leaves_date",
            )->where('attendence.user_id', $id)
            ->where("attendence.date", "LIKE", date("Y-m") . "-%")
            ->orderBy("attendence.date")
            ->get();
        return response($attendanceList, 200);
    }
    public function getSchedule(Request $request)
    {
        // $user = User::where("id",$id)->select("annual_vacation","sick_vacation")->first();
        // $schedule =Schedules::where("user_id","=",$id)->where("date",">=",date("Y-m-d"))->orderBy("date")->get();
        // return response(["schedule"=>$schedule,"vacations"=>$user],200);
    }
    public function __destruct()
    {
        $this->day = NULL;
        $this->time = NULL;
        $this->user = NULL;
    }
    public function attendence(Request $request)
    {
        date_default_timezone_set('Asia/Amman');
        $validator = Validator::make($request->all(), [
            'id' => 'required|numeric',
            'type' => 'required|in:0,1',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid Values.',
            ], 400);
        }

        $id = $request->input('id');
        $type = $request->input('type');

        try {
            $user = User::findOrFail($id);
            $currentDateTime = Carbon::now();
            $currentTime = $currentDateTime->format('H:i');
            $currentDate = $currentDateTime->format('Y-m-d');

            if ($type == 0) {
                $isChecked = Attendence::where('user_id', $id)->whereDate('date', '=', Carbon::now()->toDateString())->first();
                if ($isChecked) {
                    return response()->json([
                        'success' => false,
                        'message' => 'User has attendence for today',
                    ], 400);
                }
                $attendence = new Attendence();
                $attendence->user_id = $id;
                $attendence->type = $type;
                $attendence->check_in  = $currentTime;
                $attendence->date = $currentDate;
                $success = $attendence->save();
                $scheduale = Schedules::select('*')
                    ->where('user_id', '=', $id)
                    ->where('date', '=', $currentDate)
                    ->first();
                $latenessTxt = '';
                if ($scheduale) {
                    $from = strtotime($scheduale->from);
                    $fromDateTime = \DateTime::createFromFormat('H:i', date('H:i', $from));
                    $currentTime = \DateTime::createFromFormat('H:i', $currentTime);
                    if ($fromDateTime < $currentTime) {

                        $diff = $fromDateTime->diff($currentTime);
                        $totalMinutes = $diff->h * 60 + $diff->i;

                        if ($totalMinutes > 5) {
                            $lateness = new Lateness();
                            $lateness->user_id = $id;
                            $lateness->attendence_id = $attendence->id;
                            $lateness->amount = $totalMinutes;
                            $lateness->on = 'cehckIn';
                            $latenessSuc = $lateness->save();

                            if ($latenessSuc) {
                                $latenessTxt = ' , Lateness recorded Successfully';
                            }
                        }
                    }
                }
                if ($success) {
                    return response()->json([
                        'success' => true,
                        'message' => 'Attendence recorded Successfully' . $latenessTxt,

                    ], 200);
                } else {
                    return response()->json([
                        'success' => false,
                        'message' => 'Attendence recorded Failed.',

                    ], 400);
                }
            } else if ($type == 1) {

                $attendence = attendence::Where('user_id', '=', $id)->where('date', '=', $currentDate)->whereNotNull('check_in')->whereNull('check_out')->first();

                if ($attendence) {

                    $attendence->check_out = $currentTime;
                    $success = $attendence->save();

                    $scheduale = Schedules::select('*')
                        ->where('user_id', '=', $id)
                        ->where('date', '=', $currentDate)
                        ->first();

                    $latenessTxt = '';

                    if ($scheduale) {
                        $to = strtotime($scheduale->to);

                        $toDateTime = \DateTime::createFromFormat('H:i', date('H:i', $to));
                        $currentTime = \DateTime::createFromFormat('H:i', $currentTime);

                        $diff = $currentTime->diff($toDateTime);
                        $totalMinutes = $diff->h * 60 + $diff->i;
                        $leaveMinDiff = 0;


                        if ($currentTime <= $toDateTime) {



                            if ($totalMinutes > 10) {


                                $leave = Leave::where('user_id', '=', $id)->where('date', '=', $currentDate)->where('status', '=', 1)->where('period', '>=', $totalMinutes)->first();
                                $isLeave = false;



                                if ($leave) {

                                    $leaveFromTemp = strtotime($leave->time);
                                    $leaveToTemp = strtotime($leave->period);

                                    $leaveFrom = \DateTime::createFromFormat('H:i', date('H:i', $leaveFromTemp));


                                    $hours = $leaveFrom->format('H');
                                    $minutes = $leaveFrom->format('i');

                                    $leaveToTemp = strtotime("+$hours hours", $leaveToTemp);
                                    $leaveToTemp = strtotime("+$minutes minutes", $leaveToTemp);


                                    $leaveTo = \DateTime::createFromFormat('H:i', date('H:i', $leaveToTemp));

                                    if ($leaveFrom <= $currentTime && $leaveTo >= $toDateTime) {
                                        $isLeave = true;
                                    } else {

                                        if ($leaveFrom >= $currentTime) {


                                            $diffLeave = $leaveFrom->diff($currentTime);
                                            if ($diffLeave->h * 60 + $diffLeave->i > 10) {
                                                $leaveMinDiff += $diffLeave->h * 60 + $diffLeave->i;
                                            } else {
                                                $isLeave = true;
                                            }
                                        }
                                        if ($leaveTo <= $toDateTime) {


                                            $diffLeave = $leaveTo->diff($toDateTime);
                                            if (($diffLeave->h * 60 + $diffLeave->i) > 10) {
                                                $leaveMinDiff += $diffLeave->h * 60 + $diffLeave->i;
                                            } else {
                                                $isLeave = true;
                                            }
                                        }
                                    }
                                }


                                if ($isLeave) {


                                    $attendence->type = 10;
                                    $success = $attendence->save();
                                } else {


                                    $lateness = new Lateness();
                                    $lateness->user_id = $id;
                                    $lateness->attendence_id = $attendence->id;
                                    if ($leaveMinDiff > 0) {
                                        $lateness->amount = $leaveMinDiff;
                                    } else {
                                        $lateness->amount = $totalMinutes;
                                    }
                                    $lateness->on = 'cehckOut';

                                    $latenessSuc = $lateness->save();

                                    if ($latenessSuc) {
                                        $latenessTxt = ' , Lateness recorded Successfully';
                                    }
                                }
                            }
                        }

                        if ($currentTime > $toDateTime) {
                            if ($totalMinutes > 10) {

                                $overtime = new Overtime();
                                $overtime->user_id = $id;
                                $overtime->attendence_id = $attendence->id;
                                $overtime->amount = $totalMinutes;

                                if ($overtime->save()) {
                                    $latenessTxt = ', Overtime Added';
                                }
                            }
                        }
                    }





                    if ($success) {
                        return response()->json([
                            'success' => true,
                            'message' => 'Attendence recorded Successfully' . $latenessTxt,

                        ], 200);
                    } else {
                        return response()->json([
                            'success' => false,
                            'message' => 'Attendence recorded Failed.',

                        ], 400);
                    }
                } else {
                    return response()->json([
                        'success' => false,
                        'message' => 'There`s no Check in for user, Attendence recorded Failed.',

                    ], 400);
                }
            }
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $exception) {
            return response()->json([
                'success' => false,
                'message' => 'User does not  exist .',
            ], 404);
        }
    }
    public function checkAttendance()
    {
        $user = Auth::user();
        $data = Attendence::where("user_id", $user->id)->orderBy("date", "DESC")->select("date", "check_in", "check_out")->first();
        if (!$data) return response()->json(["success" => true, "data" => 0], 200);
        if ($data->check_in && $data->check_out) return response()->json(["success" => true, "data" => 0], 200);
        else {
            $scheduale =  Schedules::where("user_id", $user->id)->where("date", date("Y-m-d"))->orderBy("date", "DESC")->first();
            if ($scheduale) {
                $dateNow = new DateTime($scheduale->date . " " . $scheduale->from);
                $dateNow->modify('+15 hours');
                $currentDateTime = new DateTime();
                if (!$data->check_out && $currentDateTime >= $dateNow ){
                    return response()->json(["success" => true, "data" => 0], 200);
                }else return response()->json(["success" => true, "data" => 1], 200);
            }
        }
        // if (!$data->check_out) return response()->json(["success" => true, "data" => 1], 200);
        // else return response()->json(["success" => true, "data" => 0], 200);
        // return response()->json(["success" => true, "data" => $data], 200);
        // if (!$data) return response()->json(["success" => true, "data" => 0], 200);
        // if ($data->check_in && $data->check_out) return response()->json(["success" => true, "data" => 2], 200);
        // if ($data->check_in) return response()->json(["success" => true, "data" => 1], 200);
    }
}
