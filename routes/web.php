<?php

use App\Http\Livewire\BootstrapTables;
use App\Http\Livewire\Components\Buttons;
use App\Http\Livewire\Components\Forms;
use App\Http\Livewire\Components\Modals;
use App\Http\Livewire\Components\Notifications;
use App\Http\Livewire\Components\Typography;
use App\Http\Livewire\Dashboard;
use App\Http\Livewire\Employees\Employees;
use App\Http\Livewire\Employees\Promotions;
use App\Http\Livewire\Employees\PromotionEdit;
use App\Http\Livewire\Employees\AddPromotions;
use App\Http\Livewire\Employees\AddNewEmployee;
use App\Http\Livewire\Employees\Edit;
use App\Http\Livewire\Employees\View;
use App\Http\Livewire\Employees\Latenesses;
use App\Http\Livewire\Employees\Overtimes;
use App\Http\Livewire\Employees\Destroy;
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
use App\Http\Controllers\TransferController;
use App\Http\Controllers\PrivacyPolicyController;
use App\Http\Controllers\showPdf;
use App\Http\Controllers\Updateyear;
use App\Http\Livewire\Attendence\ReportAttendance;
use App\Http\Livewire\Attendence\ReportAttendecePdf;
use App\Http\Livewire\Err404;
use App\Http\Livewire\Err500;
use App\Http\Livewire\ResetPassword;
use App\Http\Livewire\ForgotPassword;
use App\Http\Livewire\Lock;
use App\Http\Livewire\Auth\Login;
use App\Http\Livewire\Profile;
use App\Http\Livewire\Auth\Register;
use App\Http\Livewire\Employees\Banks;
use App\Http\Livewire\Employees\EditPromotion;
use App\Http\Livewire\Employees\ShowPromotion;
use App\Http\Livewire\Employees\VacationBalance;
use App\Http\Livewire\ForgotPasswordExample;
use App\Http\Livewire\Index;
use App\Http\Livewire\Locations;
use App\Http\Livewire\LoginExample;
use App\Http\Livewire\ProfileExample;
use App\Http\Livewire\RegisterExample;
use App\Http\Livewire\Transactions;
use Illuminate\Support\Facades\Route;
use App\Http\Livewire\ResetPasswordExample;
use App\Http\Livewire\Salaries\DepositSalary;
use App\Http\Livewire\Salaries\DepositSalaryPdf;
use App\Http\Livewire\Salaries\NewSalary;
use App\Http\Livewire\UpgradeToPro;
use App\Http\Livewire\Users;
use App\Http\Livewire\VacationPdf;
use App\Models\Leave;

Route::redirect('/', '/login');
Route::get('/login', Login::class)->name('login');
// Route::get('/register', Register::class)->name('register');
// Route::post('/update-year', [Updateyear::class,'year'])->name('update.year');



Route::get('/forgot-password', ForgotPassword::class)->name('forgot-password');

Route::get('/reset-password/{id}', ResetPassword::class)->name('reset-password')->middleware('signed');

Route::get('/404', Err404::class)->name('404');
Route::get('/500', Err500::class)->name('500');
Route::get('/upgrade-to-pro', UpgradeToPro::class)->name('upgrade-to-pro');

Route::middleware('auth')->group(function () {
    Route::get("/locations", Locations::class)->name('locations');
    Route::get('/profile', Profile::class)->name('profile');
    Route::get('/profile-example', ProfileExample::class)->name('profile-example');
    Route::get('/users', Users::class)->name('users');
    Route::get('/login-example', LoginExample::class)->name('login-example');
    Route::get('/register-example', RegisterExample::class)->name('register-example');
    Route::get('/forgot-password-example', ForgotPasswordExample::class)->name('forgot-password-example');
    Route::get('/reset-password-example', ResetPasswordExample::class)->name('reset-password-example');
    Route::get('/dashboard', Dashboard::class)->name('dashboard');


    Route::get('/transactions', Transactions::class)->name('transactions');
    Route::get('/bootstrap-tables', BootstrapTables::class)->name('bootstrap-tables');
    Route::get('/lock', Lock::class)->name('lock');
    Route::get('/buttons', Buttons::class)->name('buttons');
    Route::get('/notifications', Notifications::class)->name('notifications');
    Route::get('/forms', Forms::class)->name('forms');
    Route::get('/modals', Modals::class)->name('modals');
    Route::get('/typography', Typography::class)->name('typography');
    Route::get('/typography', Typography::class)->name('typography');



    Route::prefix('employees')->group(function () {
        Route::get("/banks", Banks::class)->name("employee.banks");
        Route::get("/vacation-balance", VacationBalance::class)->name("employee.VacationBalance");
        Route::get('/', Employees::class)->name('employees'); //->middleware('permission:viewAllEmployees');
        Route::get('/addEmployee', AddNewEmployee::class)->name('employees.addNew'); //->middleware('permission:addEmployees');
        Route::get('/{user}/edit', Edit::class)->name('employees.edit');
        Route::get('/{user}/view', View::class)->name('employees.view');
        Route::get('/remove/{user}', [Employees::class, 'Remove'])->name('employees.remove'); //->middleware('permission:deleteEmployee');
        Route::get('/lateness', Latenesses::class)->name('employees.lateness'); //->middleware('permission:viewAllEmployees');
        Route::get('/overtime', Overtimes::class)->name('employees.overtime'); //->middleware('permission:viewAllEmployees');
        Route::prefix('promotions')->group(function(){
            Route::get('/', Promotions::class)->name('promotions'); //->middleware('permission:viewAllEmployees');
            Route::get('/add', AddPromotions::class)->name('promotions.add'); //->middleware('permission:viewAllEmployees');
            Route::get('/edit/{id}', EditPromotion::class)->name('edit.promotions'); //->middleware('permission:viewAllEmployees');
            Route::get('/show/{id}', ShowPromotion::class)->name('show.promotions'); //->middleware('permission:viewAllEmployees');
            Route::delete('/delete', Promotions::class,"delete")->name('promotions.delete'); //->middleware('permission:viewAllEmployees');
        });
    });


    Route::prefix('leaves')->group(function () {
        Route::get('/', Leaves::class)->name('leaves');
        Route::get('/{leave}/approve', [Leaves::class, 'approve'])->name('leaves.approve'); //->middleware('permission:leaveReqAction');
        Route::get('/{leave}/reject', [Leaves::class, 'reject'])->name('leaves.reject'); //->middleware('permission:leaveReqAction');
    });


    Route::prefix('vacations')->group(function () {
        Route::get('/', Vacations::class)->name('vacations');
        Route::get("/report/{id}/{date}", VacationPdf::class)->name("vacations.report");
        // Route::get('/{vacation}/{type}/{user_id}/approve', [Vacations::class, 'approve'])->name('vacations.approve'); //->middleware('permission:vactionReqAction');
        // Route::get('/{vacation}/reject', [Vacations::class, 'reject'])->name('vacations.reject'); //->middleware('permission:vactionReqAction');
    });


    Route::prefix('attendence')->group(function () {
        Route::get('/', Attendences::class)->name('attendences'); //->middleware('permission:viewAttendence');
        // Route::get("/report_Attendence/{id}/{date}",ReportAttendance::class)->name("reportAttendence");
        Route::get("/report", ReportAttendance::class)->name("attendence.Report");
        Route::get("/reportPdf/{id}/{date}", ReportAttendecePdf::class)->name("attendence.Report.pdf");
    });


    Route::prefix('schedule')->group(function () {
        Route::get('/', Schedule::class)->name('schedule');
        Route::get('/set-schedule', SetSchedule::class)->name('schedule.set');
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



    Route::prefix('deductions')->group(function () {
        Route::get('/', DeductionsController::class)->name('deductions'); //->middleware('role:viewroles')
    });

    Route::prefix('allownces')->group(function () {
        Route::get('/', AllowncesController::class)->name('allownces'); //->middleware('role:viewroles')
    });

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


    Route::prefix('departments')->group(function () {
        Route::get('/', Departments::class)->name('departments'); //->middleware('role:viewroles')

    });
});




Route::get('/transfer', [TransferController::class, 'transfer'])->name('transfer'); //->middleware('role:viewroles')





Route::get('/privay_policy', [PrivacyPolicyController::class, 'privacy'])->name('privacy_policy');
Route::get('/description', [PrivacyPolicyController::class, 'description'])->name('description');
Route::get("/storage/app/public/contracts/{filename}", [showPdf::class, "pdfView"])->name("viewContract");