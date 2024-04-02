<?php
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\api\login\LoginController;
use App\Http\Controllers\api\login\ForgetPasswordController;
use App\Http\Controllers\api\attendence\AttendanceController;
use App\Http\Controllers\api\attendence\AttendenceDay;
use App\Http\Controllers\api\attendence\attendenceRecord;
use App\Http\Controllers\Api\Attendence\createAttendence;
use App\Http\Controllers\Api\Auth\ForgetPassController;
use App\Http\Controllers\api\Auth\LoginController as AuthLoginController;
use App\Http\Controllers\api\Auth\RegisterController;
use App\Http\Controllers\api\Auth\LogoutController;
use App\Http\Controllers\api\Auth\ResetPassword;
use App\Http\Controllers\api\Auth\VerfyOtpController;
use App\Http\Controllers\Api\EmployeeSalariesReport;
use App\Http\Controllers\api\Leave\LeaveController;
use App\Http\Controllers\api\leaves\LeaveReqController;
use App\Http\Controllers\api\leaves\GetLeaveController;
use App\Http\Controllers\api\vacations\VacationReqController;
use App\Http\Controllers\api\vacations\GetVacationController;
use App\Http\Controllers\api\profile\ProfileController;
use App\Http\Controllers\api\profile\showProfileImageController;
use App\Http\Controllers\api\vacations\VacationController;
use App\Http\Controllers\LocationController;

Route::middleware(['api'])->group(function () {
Route::post('/profile', [ProfileController::class, 'profile']); 
});
Route::post('/login', [LoginController::class, 'login']);
Route::post('/ActivateOtp', [LoginController::class, 'sendOtp']);
Route::post('/ActivateVerifyOtp', [LoginController::class, 'verifyOtp']);

Route::post('/attendence', [AttendanceController::class, 'attendence']);
Route::post("attendence/record",[attendenceRecord::class,"recordApi"])->name("attendence.record.api");
Route::post("attendence/schedule",[attendenceRecord::class,"getSchedule"])->name("attendence.getSchedule.api");

Route::post('/leaveReq', [LeaveReqController::class, 'leaveReq']);
Route::post('/vacationReq', [VacationReqController::class, 'vacationReq']);
Route::post('/getVacation', [GetVacationController::class, 'getVacations']);
Route::post('/getLeave', [GetLeaveController::class, 'getLeaves']);

Route::post('/getProfile', [ProfileController::class, 'getProfile']);
Route::post('/profileOTP', [ProfileController::class, 'profileOTP']);
Route::post('/updateProfile', [ProfileController::class, 'editProfile']);
Route::post('/profilePassword', [ProfileController::class, 'profilePassword']);
Route::post('/profileIMG/{filename}', [showProfileImageController::class, 'showProfileImage']);

Route::post("/register",[RegisterController::class,"create"])->name("register");
Route::post("/delete",[RegisterController::class,"destroy"])->name("delete");
Route::post('forget-password', [ForgetPasswordController::class, 'forget']);
Route::post('forget-password-otp', [ForgetPasswordController::class, 'verifyOtp']);
Route::post('reset-password', [ForgetPasswordController::class, 'resetPassword']);
// new api
Route::middleware(["guest:sanctum"])->prefix("auth")->name("auth.")->group(function(){
    Route::post("login"          , [AuthLoginController::class          ,'login' ])->name("login");
    Route::post("register"       , [RegisterController::class           ,"create"])->name("register");
    Route::post('forget-password', [ForgetPasswordController::class,"forgetPassword"] )->name("forgetPassword");
    Route::post('verfy-otp'      , [VerfyOtpController::class, 'verifyOtp'])->name("verfyOtp");
    Route::post('reset-password' , [ResetPassword::class, 'ResetPassword'])->name("resetPassword");
});
Route::post('EmployeeSalariesReport'         , [EmployeeSalariesReport::class, 'index'])->name("employeeSalariesReport")->middleware("guest:sanctum");
Route::middleware(["auth:sanctum"])->group(function(){
    Route::get("auth/logout",[AuthLoginController::class,"logout"])->name("logout");
    Route::get("locations",[LocationController::class,"get"])->name("locations.get");
    Route::prefix("attendence")->name("attendence.")->group(function(){
        Route::post("create"    ,[AttendanceController::class,"create"])->name("create");
        Route::post("check",[AttendanceController::class,"checkAttendance"])->name("today");
    });
    Route::prefix("leave")->name("leave.")->group(function(){
        Route::get("/"    ,[LeaveController::class,"get"])->name("get");
        Route::post("create"    ,[LeaveController::class,"create"])->name("create");
        Route::put("edit/{id}"    ,[LeaveController::class,"edit"])->name("edit");
        Route::delete("delete/{id}"    ,[LeaveController::class,"delete"])->name("delete");
        Route::get("checkin"    ,[LeaveController::class,"checkin"])->name("checkin");
        Route::get("checkout"    ,[LeaveController::class,"checkout"])->name("checkout");
        Route::get("leave-control"    ,[LeaveController::class,"control"])->name("control");
    });
    Route::prefix("vacation")->name("vacation.")->group(function(){
        // Route::get("/"    ,[LeaveController::class,"get"])->name("get");
        Route::post("/"    ,[VacationController::class,"get"])->name("get");
        Route::post("create"    ,[VacationController::class,"create"])->name("create");
        Route::post("edit/{id}"    ,[VacationController::class,"edit"])->name("edit");
        Route::delete("delete/{id}"    ,[VacationController::class,"delete"])->name("delete");
        // Route::put("edit/{id}"    ,[LeaveController::class,"edit"])->name("edit");
        // Route::delete("delete/{id}"    ,[LeaveController::class,"delete"])->name("delete");
    });
    Route::prefix("profile")->name("profile.")->group(function(){
        Route::post('updateProfileInfo',[ProfileController::class,"updateProfileInfo"]);
        // Route::put("edit",[ProfileController::class, 'editProfile'])->name("edit");
        // Route::put("password",[ProfileController::class, 'editProfile'])->name("password");
    });
    // Route::prefix("attendence")->name("attendence.")->group(function(){
    //     Route::get("/today",[AttendenceToday::class,"AttendenceToday"])->name("today");
    //     Route::post('/', [AttendanceController::class, 'attendence']);
    //     Route::post("attendence/record",[attendenceRecord::class,"recordApi"])->name("attendence.record.api");
    //     Route::post("attendence/schedule",[attendenceRecord::class,"getSchedule"])->name("attendence.getSchedule.api");
    // });
    // Route::prefix("leave")->name("leave.")->group(function(){
    //     Route::post('/', [AttendanceController::class, 'attendence']);
    //     Route::post("attendence/record",[attendenceRecord::class,"recordApi"])->name("attendence.record.api");
    //     Route::post("attendence/schedule",[attendenceRecord::class,"getSchedule"])->name("attendence.getSchedule.api");
    // });
});
// new api