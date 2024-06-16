<?php

use App\Models\Hirarc;
use App\Models\Incident;
use App\Events\MessageCreated;
use App\Events\NewHirarcAdded;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\HirarcController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\IncidentController;
use App\Http\Controllers\NewPasswordController;
use App\Http\Controllers\UpperManagementController;
use App\Http\Controllers\IncidentAnalysisController;
use App\Http\Controllers\IncidentInvestigationController;
use Andyabih\LaravelToUML\Http\Controllers\LaravelToUMLController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/
Route::get('/', function () {
    // MessageCreated::dispatch('camamm');
    // $hirarc = Hirarc::find(83); // Assuming you have a Hirarc instance to pass to the event
    // // dd(new NewHirarcAdded($hirarc));
    // event(new NewHirarcAdded($hirarc));
    return view('auth.login');
});

Route::get('/dashboard', [UserController::class, 'checkFirstTimeStatus'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::get('/dashboard-with-year', [UserController::class, 'dashboardWithYear'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard-year');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::get('/admin/users-list',[\App\Http\Controllers\UserController::class, 'getUsersLists'])->name('admin.users-list');

Route::get('/update-to-new-password', [UserController::class, 'updateFirstTimePassword'])->name('update-to-new-password');
Route::get('/admin/users-registration-form', [\App\Http\Controllers\UserController::class, 'getUsersRegistrationForm'])->name('admin-users-registration-form');

Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/admin/register', function () {
        return view('admin.register'); // Your admin registration view
    })->name('admin.register');
    Route::post('/admin/register', 'AdminController@registerUser'); // Controller method to register user
});
Route::post('/admin/register', [AdminController::class, 'registerUser'])->name('admin.register.post');

Route::get('/admin/edit-users-form/{id}', [AdminController::class, 'getEditUserAccountForm'])->name('admin-edit-user-account');
//admin reset password users
Route::post('/admin/reset-password/{id}', [AdminController::class, 'resetUserPassword'])->name('admin-reset-password');
// admin delete users
Route::delete('/admin/delete-user/{id}', [AdminController::class, 'deleteUser'])->name('admin-delete-user');

// Route::post('/reset-password/{token}', [NewPasswordController::class, 'store'])
//     ->middleware(['guest'])
//     ->name('password.store');
Route::post('/password/store', [UserController::class, 'resetFirstTimePassword'])->name('user-reset-password');
Route::post('/disable-user/{id}', [AdminController::class, 'disableUser'])->name('admin-disable-user');

//supervisor route (incident)
Route::get('/user/incident-list', [IncidentController::class, 'getIncidentList'])->name('user-incident-list');
Route::get('/user/incident-form', [IncidentController::class, 'getIncidentForm'])->name('user-incident-form');
Route::post('/user/insert-incident', [IncidentController::class, 'postAddIncident'])->name('user-add-incident');
Route::get('/user/update-incident-form/{id}', [IncidentController::class, 'getEditIncidentForm'])->name('user-edit-incident');
Route::put('/user/update-incident/{id}', [IncidentController::class, 'putEditIncident'])->name('user-update-incident');
Route::delete('/user/delete-incident/{id}', [IncidentController::class, 'deleteIncident'])->name('user-delete-incident');
Route::post('/delete-image-incident', [IncidentController::class, 'deleteImage'])->name('user-delete-image1');

//Hirarc
Route::match(['get', 'post'],'/user/hirarc-list', [HirarcController::class, 'getHirarcList'])->name('user.hirarc-list');  //view hirarc lists
Route::get('/user/hazard-details', [HirarcController::class, 'getHirarcFormHazard'])->name('user.hirarc-form-view');   //untuk view hazard details
Route::get('/user/hirarc-form-titlepage', [HirarcController::class, 'getHirarcForm'])->name('user.hirarc-form-titlepage');  
// Route::post('/user/hirarc-form-hirarc', [HirarcController::class, 'getHirarcForm'])->name('user.hirarc-form-hirarc');
Route::get('/user/hirarc-form-risk', [HirarcController::class, 'getHirarcFormRisk'])->name('user-hirarc-risks');
Route::post('/user/hirarc-form-control', [HirarcController::class, 'getHirarcFormControl'])->name('user-hirarc-control');
Route::post('/user/hirarc-form-hirarc', [HirarcController::class, 'postAddTitleDetails'])->name('user-add-titlepage');      //untuk add titlepage details
Route::get('/user/hirarc-form-hirarc-details', [HirarcController::class, 'postAddHirarcDetail'])->name('user-add-hirarc-details');      //untuk add titlepage details
Route::post('/user/add-hirarc-details', [HirarcController::class, 'postAddHirarcDetails'])->name('user.add-hirarc-form');   //untuk add hirarc details
Route::post('/user/add-control-details', [HirarcController::class, 'postAddControlDetails'])->name('user-add-control'); //untuk add Control Details
Route::post('/user/add-hazard-details', [HirarcController::class, 'postAddHazardDetails'])->name('user-add-hazards');   //untuk add HAZARD details
Route::post('/user/add-risk-details', [HirarcController::class, 'postAddRisksDetails'])->name('user-add-risks');    //untuk add risks details
//edit Hirarc
Route::get('/user/edit-titlepage-details/{hirarc_id}', [HirarcController::class, 'getEditHirarcForm'])->name('user-edit-hirarc');    //untuk add risks details
Route::put('/user/edit-titlepage-items/{tpage_id}', [HirarcController::class, 'putEditTitlePage'])->name('user-edit-titlepage-details');    //untuk edit tpage details
Route::put('/user/edit-hirarc-items/{hirarc_id}', [HirarcController::class, 'putEditHirarcDetails'])->name('user-edit-hirarc-details');    //untuk edit hirarc details
Route::put('/user/edit-hazard-items/{hirarc_id}', [HirarcController::class, 'putEditHazardDetails'])->name('user-edit-hazard-details');    //untuk edit hazard details
Route::put('/user/edit-risk-items/{hirarc_id}', [HirarcController::class, 'putEditRiskDetails'])->name('user-edit-risk-details');    //untuk edit risk details
Route::put('/user/edit-control-items/{hirarc_id}', [HirarcController::class, 'putEditControlDetails'])->name('user-edit-control-details');    //untuk edit control details
Route::delete('/user/delete-hirarc/{hirarc_id}', [HirarcController::class, 'deleteHirarc'])->name('user-delete-hirarc');    //untuk edit control details
Route::get('/user/edit-titlepage-detailss/{tpage_id}', [HirarcController::class, 'backToTitlePage'])->name('user-edit-titlepage-hirarc');    //untuk add risks details
Route::put('/user/edit-hazard-items-back/{hirarc_id}', [HirarcController::class, 'backToHazardFromRisk'])->name('user-backto-hazard-details'); 
Route::put('/user/edit-risk-items-back/{hirarc_id}', [HirarcController::class, 'backToRiskFromControl'])->name('user-backto-risk-details'); 
Route::get('/user//generate-hirarc-report/{hirarc_id}', [HirarcController::class, 'generatePDF'])->name('pdf-generate'); //generate PDF report for HIRARC
// routes/web.php




//Incident Analysis
Route::get('/user/incident-analysis', [IncidentAnalysisController::class, 'getIncidentAnalysis'])->name('user-incident-analysis');
Route::get('/user/incident-analysis-monthly', [IncidentAnalysisController::class, 'getIncidentAnalysisMonthly'])->name('user-incident-analysis-monthly');
Route::get('/user/incident-analysis-monthly-specific', [IncidentAnalysisController::class, 'monthlySafetyAnalysisFor'])->name('user-incident-analysis-for-');

Route::get('/user/hirarc-form-approval', [UpperManagementController::class, 'getManagementApprovalList'])->name('user.management-approval-list');
Route::get('/user/hirarc-form-approve/{hirarc_id}', [UpperManagementController::class, 'approveHirarcForm'])->name('manager-approve-form');     //to approve form (manager)
Route::get('/user/hirarc-form-verify/{hirarc_id}', [UpperManagementController::class, 'verifyHirarcForm'])->name('manager-verify-form');     //to verify form (sho)
Route::post('/user/hirarc-form-approve-with-signature', [UpperManagementController::class, 'postAddApprovalDetails'])->name('manager-approve-form-confirm');    //add approval details
Route::post('/user/hirarc-form-verify-with-signature', [UpperManagementController::class, 'postAddVerificationDetails'])->name('manager-verify-form-confirm');    //add approval details

//Incident Investigation
Route::get('/user/incident-investigation-list', [IncidentInvestigationController::class, 'getIncidentList'])->name('incident-investigation-list');
Route::get('/user/investigation-form/{reportNo}', [IncidentInvestigationController::class, 'getIncidentInvestigationReport'])->name('incident-investigation-form');
Route::get('/user/investigation-form-partb/{reportNo}', [IncidentInvestigationController::class, 'getIncidentInvestigationReportBForm'])->name('incident-investigation-form-b');
Route::get('/user/investigation-form-update/{reportNo}', [IncidentInvestigationController::class, 'putEditIncidentInvestigationReport'])->name('update-incident-investigation-form');
Route::get('/user/investigation-form-update-part-b/{id}', [IncidentInvestigationController::class, 'putEditIncidentInvestigationReportB'])->name('form-update-incident-investigation-form-b');
Route::post('/user/submit-investigation-form-parta/{reportNo}', [IncidentInvestigationController::class, 'submitIncidentPartA'])->name('submit-investigation-form-a');
Route::post('/user/submit-investigation-form-partb/{reportNo}', [IncidentInvestigationController::class, 'submitIncidentPartB'])->name('submit-investigation-form-b');
Route::post('/user/update-investigation-form-parta/{reportNo}', [IncidentInvestigationController::class, 'updateIncidentPartA'])->name('update-investigation-form-a');
Route::post('/user/update-investigation-form-partb/{id}', [IncidentInvestigationController::class, 'updateIncidentPartB'])->name('update-investigation-form-b');
// Route::get('/user/update-investigation-form-partb/{id}', [IncidentInvestigationController::class, 'getIncidentInvestigationReportB'])->name('update-investigation-form-b');
Route::get('/user/printInvestigationReport/{reportNo}', [IncidentInvestigationController::class, 'printFullReport'])->name('print-investigation-report');
Route::get('/searchHirarc', [IncidentInvestigationController::class, 'searchHirarc'])->name('searchHirarc');
Route::get('/searchUser', [IncidentInvestigationController::class, 'searchUser'])->name('searchUser');
Route::post('/delete-image', [IncidentInvestigationController::class, 'deleteImage'])->name('delete-image');
//emergency create user
Route::get('/registernewuser', [UserController::class, 'getUsersRegistrationForm']);

require __DIR__.'/auth.php';
