<?php

use App\Http\Controllers\TransferController;
use Illuminate\Support\Facades\Route;
use App\Http\Livewire\Auth\Login;
use App\Http\Livewire\Auth\ForgotPassword;
use App\Http\Livewire\Auth\ResetPassword;
use App\Http\Livewire\Dashboard\Index as DashboardIndex;
use App\Http\Livewire\Profile\Index as ProfileIndex;
use App\Http\Livewire\Employees\Index as EmployeesIndex;
use App\Http\Livewire\Employees\Create as EmployeesCreate;
use App\Http\Livewire\Employees\Edit as EmployeesEdit;
use App\Http\Livewire\Employees\View as EmployeesView;
use App\Http\Livewire\Promotions\Index as PromotionsIndex;
use App\Http\Livewire\Promotions\Create as PromotionsCreate;
use App\Http\Livewire\Promotions\Edit as PromotionsEdit;
use App\Http\Livewire\Promotions\View as PromotionsView;
use App\Http\Livewire\Banks\Index as BankIndex;
use App\Http\Livewire\Employees\Latenesses;
use App\Http\Livewire\Employees\Overtimes;
use App\Http\Livewire\Leaves\Leaves;
use App\Http\Livewire\Vacations\Vacations;
use App\Http\Livewire\Attendence\Attendences;
use App\Http\Livewire\Schedule\Schedule;
use App\Http\Livewire\Schedule\SetSchedule;
use App\Http\Livewire\Deductions\DeductionsController;
use App\Http\Livewire\Allownces\AllowncesController;
use App\Http\Livewire\Salaries\Salaries;
use App\Http\Livewire\Salaries\Slips;
use App\Http\Livewire\Salaries\AddSalaries;
use App\Http\Livewire\Salaries\AddPartTimes;
use App\Http\Livewire\Salaries\EditPartTimes;
use App\Http\Livewire\Salaries\ViewPartTimes;
use App\Http\Livewire\Salaries\PartTimes;
use App\Http\Livewire\Salaries\Ptreportpdf;
use App\Http\Livewire\Salaries\SlipReportpdf;
use App\Http\Livewire\Salaries\SocialSecurityController;
use App\Http\Livewire\Permission\Permissions;
use App\Http\Livewire\Permission\PermissionEdit;
use App\Http\Livewire\Permission\PermissionRoles;
use App\Http\Livewire\Permission\PermissionRolesEdit;
use App\Http\Livewire\Role\Roles;
use App\Http\Livewire\Role\AddnewRole;
use App\Http\Livewire\Departments\Departments;
use App\Http\Livewire\Attendence\ReportAttendance;
use App\Http\Livewire\Attendence\ReportAttendecePdf;
use App\Http\Livewire\Employees\VacationBalance;
use App\Http\Livewire\Locations;
use App\Http\Livewire\Salaries\DepositSalary;
use App\Http\Livewire\Salaries\DepositSalaryPdf;
use App\Http\Livewire\Salaries\NewSalary;
use App\Http\Livewire\Users;
use App\Http\Livewire\VacationPdf;

Route::get('/transfer', [TransferController::class, 'transfer'])->name('transfer'); //->middleware('role:viewroles')
Route::middleware("guest")->group(function () {
    Route::redirect('/', '/login');
    Route::get('/login', Login::class)->name('login');
    Route::get('/forgot-password', ForgotPassword::class)->name('forgot-password');
    Route::get('/reset-password/{id}', ResetPassword::class)->name('reset-password')->middleware('signed');
});
// test1
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', DashboardIndex::class)->name('dashboard.index');
    Route::get('/profile', ProfileIndex::class)->name('profile.index');
    Route::prefix('employees')->name("employees.")->group(function () {
        Route::get('/', EmployeesIndex::class)->name('index'); //->middleware('permission:viewAllEmployees');
        Route::get('/create', EmployeesCreate::class)->name('create'); //->middleware('permission:addEmployees');
        Route::get('view/{user}', EmployeesView::class)->name('view');
        Route::get('edit/{user}', EmployeesEdit::class)->name('edit');
    });
    Route::prefix('promotions')->name('promotions.')->group(function () {
        Route::get('/', PromotionsIndex::class)->name('index'); //->middleware('permission:viewAllEmployees');
        Route::get('/create', PromotionsCreate::class)->name('create'); //->middleware('permission:viewAllEmployees');
        Route::get('/edit/{id}', PromotionsEdit::class)->name('edit'); //->middleware('permission:viewAllEmployees');
        Route::get('/show/{id}', PromotionsView::class)->name('view'); //->middleware('permission:viewAllEmployees');
        Route::delete('/delete', PromotionsIndex::class, "delete")->name('delete'); //->middleware('permission:viewAllEmployees');
    });
    Route::get("/banks", BankIndex::class)->name("banks.index");
    Route::get("/vacation-balance", VacationBalance::class)->name("employee.VacationBalance");
    Route::prefix('attendence')->group(function () {
        Route::get('/', Attendences::class)->name('attendences'); //->middleware('permission:viewAttendence');
        Route::get("/report", ReportAttendance::class)->name("attendence.Report");
        Route::get("/reportPdf/{id}/{date}", ReportAttendecePdf::class)->name("attendence.Report.pdf");
        Route::get('/lateness', Latenesses::class)->name('employees.lateness'); //->middleware('permission:viewAllEmployees');
        Route::get('/overtime', Overtimes::class)->name('employees.overtime'); //->middleware('permission:viewAllEmployees');
    });
    Route::prefix('leaves')->group(function () {
        Route::get('/', Leaves::class)->name('leaves');
        Route::get('/{leave}/approve', [Leaves::class, 'approve'])->name('leaves.approve'); //->middleware('permission:leaveReqAction');
        Route::get('/{leave}/reject', [Leaves::class, 'reject'])->name('leaves.reject'); //->middleware('permission:leaveReqAction');
    });
    Route::prefix('vacations')->group(function () {
        Route::get('/', Vacations::class)->name('vacations');
        Route::get("/report/{id}/{date}", VacationPdf::class)->name("vacations.report");
    });
    Route::prefix('schedule')->group(function () {
        Route::get('/', Schedule::class)->name('schedule');
        Route::get('/set-schedule', SetSchedule::class)->name('schedule.set');
    });
    Route::get('/deductions', DeductionsController::class)->name('deductions'); //->middleware('role:viewroles')
    Route::get('allownces/', AllowncesController::class)->name('allownces'); //->middleware('role:viewroles')
    Route::get('departments/', Departments::class)->name('departments'); //->middleware('role:viewroles')
    Route::get("/locations", Locations::class)->name('locations');
    Route::get('/users', Users::class)->name('users');
    Route::get('slip-report/{id}', [SlipReportpdf::class, 'generatePDF'])->name('payrolls.slip_report'); //->middleware('role:viewroles')
    Route::prefix('payrolls')->group(function () {
        Route::get('/salaries', Salaries::class)->name('payrolls.salaries'); //->middleware('role:viewroles')
        Route::get('/slips', Slips::class)->name('payrolls.slips'); //->middleware('role:viewroles')
        Route::get('/parttime', PartTimes::class)->name('payrolls.part_time'); //->middleware('role:viewroles')
        Route::get('/addParttime', AddPartTimes::class)->name('payrolls.add_part_time'); //->middleware('role:viewroles')
        Route::get('/{parttime}/editParttime', EditPartTimes::class)->name('payrolls.edit_part_time'); //->middleware('role:viewroles')
        Route::get('/{parttime}/viewParttime', ViewPartTimes::class)->name('payrolls.view_part_time'); //->middleware('role:viewroles')
        Route::get('/FullTimeReport/{id}/{from}/{to}', [SlipReportpdf::class, 'FullTimegeneratePDF'])->name('payrolls.fullTimeReport'); //->middleware('role:viewroles')
        Route::get('/PartTime_Reports/{id}/{from}/{to}', [Ptreportpdf::class, 'generatePDF'])->name('payrolls.part_time_report'); //->middleware('role:viewroles')
        Route::get('/addSalary', AddSalaries::class)->name('payrolls.addSalary'); //->middleware('role:viewroles')
        Route::get('/socialsecurity', SocialSecurityController::class)->name('payrolls.socialsecurity'); //->middleware('role:viewroles')
        Route::get('/new-salary', NewSalary::class)->name('payrolls.newSalary'); //->middleware('role:viewroles')
        Route::any('/depositsalary/{id_salary}/{id}/{salary}', DepositSalary::class)->name('payrolls.depositsalary'); //->middleware('role:viewroles')
        Route::get('/deposit-salarypdff/{id}', DepositSalaryPdf::class)->name('payrolls.depositSalarypdf'); //->middleware('role:viewroles')
    });
    Route::prefix('permissions')->group(function () {
        Route::get('/', Permissions::class)->name('permissions'); //->middleware('permission:viewPermissions')
        Route::get('/{user}/edit', PermissionEdit::class)->name('permissions.edit'); //->middleware('permission:editPermissions')
        Route::get('/roles', PermissionRoles::class)->name('permissions.roles'); //->middleware('permission:editPermissions')
        Route::get('/roles/{role}/edit', PermissionRolesEdit::class); //->name('permissions.role.edit'); //->middleware('permission:editPermissions')

    });
    Route::prefix('roles')->group(function () {
        Route::get('/', Roles::class)->name('roles'); //->middleware('role:viewroles')
        Route::get('/addNewRole', AddnewRole::class)->name('role.addNew'); //->middleware('role:viewroles')
        Route::get('/{role}/edit', PermissionRolesEdit::class)->name('permissions.role.edit');
        Route::get('/{role}/remove', Roles::class, 'remove')->name('role.remove');
    });
});
