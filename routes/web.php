<?php
use App\Http\Controllers\TrakrController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\TemplateController;
use App\Http\Controllers\TrakrViewController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\SupportController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\SettingsController;
use App\Http\Controllers\UploadImages;
use App\Http\Controllers\UploadImagesController;
use App\Http\Controllers\LocationController;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Route::get('/feed' , function(){
	return view('feed');
});
Route::get('/', function () {
	// return view('welcome');
	return redirect()->route('login');
});

// Route::get('/manual_admin_create' , function() {
// 	$user = new App\Models\User();
// 	$user->name = 'Admin';
// 	$user->uuid = 736129;
// 	$user->email = 'devs@gmail.com';
// 	$user->email_verified_at = date('Y-m-d H:i:s');
// 	$user->is_admin = 1;
// 	$user->password = Hash::make('admindevs');
// 	$user->save();
// });


Route::prefix('dashboard')->middleware(['auth'])->group(function(){
	Route::get('/', [DashboardController::class, 'index'])->name('home');
	Route::get('/show-all' ,[DashboardController::class , 'showAll'])->name('showAll');
	Route::get('/show-all/search' ,[DashboardController::class , 'showAllSearch'])->name('showAllSearch');
});
Route::get('/generate_pdf' , [DashboardController::class , 'generate_pdf'])
	->middleware(['auth'])
	->name('generate_pdf');
	
Route::prefix('settings')->middleware(['auth', 'verified'])->group(function () {
	Route::get('/', [SettingsController::class , 'index'])->name('profile');
	Route::view('/changepassword', 'profile.update_password')->name('profile-update');
	Route::post('/add_admin' , [SettingsController::class , 'new_admin'])->name('add-new-admin');
	Route::get('/manage/all/admins' , [SettingsController::class , 'customerAdmins'])->name('customerAdmins');
	Route::get('/qr/login/view' , [SettingsController::class , 'generatePDF'])->name('qrpdf');
	Route::get('/question-settings' , [SettingsController::class , 'viewSettings'])->name('viewSettings');
	Route::post('/question-settings' , [SettingsController::class , 'saveSettings'])->name('saveSettings');
	Route::post('/signin-settings' , [SettingsController::class , 'signOutSettings'])->name('signOutSettings');
	Route::post('/get-account-details' , [SettingsController::class , 'accountDetails'])->name('accountDetails');
	Route::post('/save-account-details' , [SettingsController::class , 'accountDetailsSave'])->name('accountDetailsSave');
});

Route::prefix('trakrid')->middleware(['auth', 'verified'])->group(function () {
	Route::get('/', [TrakrController::class, 'index'])->name("trakr-index");
	Route::get('/add', [TrakrController::class, 'create'])->name("trakr-add");
	Route::post('/add', [TrakrController::class, 'store'])->name("trakr-store");
	Route::get('/edit/{trakr}', [TrakrController::class, 'edit'])->name("trakr-edit");
	Route::post('/edit/{trakr}', [TrakrController::class, 'update'])->name("trakr-update");
	Route::get('/delete/{trakr}', [TrakrController::class, 'destroy'])->name("trakr-delete");
	// Safe CheckBox
	Route::post('update/safe', [TrakrController::class, 'safeupdate'])->name("trakr-safe");
	// manual sign out
	Route::post('manual/visitor/signout' , [TrakrController::class , 'manualSignOut'])->name('manualSignOut');
	// Search
	Route::get('/search' , [TrakrController:: class , 'searchTrakr'])->name('searchTrakr');
});
Route::prefix('templates')->middleware(['auth', 'verified'])->group(function () {
	Route::get('/', [TemplateController::class, 'index'])->name("template-index");
	Route::get('/notification-add', [TemplateController::class, 'notificationcreate'])->name("notification-add");
	Route::get('/notification-edit/{id}', [TemplateController::class, 'notificationedit'])->name("notification-edit");
	Route::post('/notification-edit/{id}', [TemplateController::class, 'notificationupdate'])->name("notification-update");
	Route::get('/questionnaire/add', [TemplateController::class, 'questionView'])->name("questionnaire-add");
	Route::post('/questionnaire/add/new', [TemplateController::class, 'questionAdd'])->name("questionnaire-add-new");
	Route::get('/question-edit/{id}', [TemplateController::class, 'questionEdit'])->name("question-edit");
	Route::post('/question-edit/{id}', [TemplateController::class, 'questionUpdate'])->name("question-update");
	Route::get('/activate/{id}', [TemplateController::class, 'activate'])->name("activate");
	Route::get('/deactivate/{id}', [TemplateController::class, 'deactivate'])->name("deactivate");
	Route::get('/question/change_status/{id}', [TemplateController::class, 'QuestionChangeStatus'])->name("change_status");
	Route::post('/add', [TemplateController::class, 'save_new_notifications'])->name("template-store");
	Route::get('/delete/{template}', [TemplateController::class, 'destroy'])->name("template-delete");
});
Route::prefix('trakr')->group(function () {
	Route::get('/notification-checking/{userid?}' , [TrakrViewController::class , 'notificationCheck'])->name('notification-check');
	Route::get('/{id}/visitor-checkin', [TrakrViewController::class, 'index'])->name("trakr-view");
	Route::post('/trakrid/check', [TrakrViewController::class, 'trakrid'])->name("trakrid-post"); //for simple check in
	Route::post('/visitor-checkin', [TrakrViewController::class, 'create'])->name("trakr-post"); //for manual check in new visitors
	Route::post('/trakrid/checkout', [TrakrViewController::class, 'trakrcheckout'])->name("trakrid-signout");
	Route::post('/trakr/visiting_who', [TrakrViewController::class, 'visitingWho'])->name("visiting-who");
	Route::post('/trakr/business', [TrakrViewController::class, 'business'])->name("business");
	Route::post('/visitor/answers' , [TrakrViewController::class , 'visitorAnswer'])->name('employee-answer');
	Route::post('/visitor/checktrakrid' , [TrakrViewController::class , 'trakrIdCheck'])->name('check-trakr-id');
	Route::post('/visitor/save/trakr' , [TrakrViewController::class , 'saveTrakrId'])->name('save-trakr-id');
	Route::get('/visitor/cancel/{trakr}' , [TrakrViewController::class , 'cancelSignin'])->name('cancelSignin');
	// qr
	Route::get('/qr/login/{uuid}/{userid}' , [TrakrViewController::class,'QRLoginView'])->name('qr-login-view');
	Route::post('/qr/login/{userid?}' , [TrakrViewController::class,'create'])->name('qr-login');
	
	//stepper questions
	Route::get('/qr/login/stepper/{visitor_id}/{userid}/{question_id}' , [TrakrViewController::class , 'stepper'])->name('stepper');
	Route::post('/stepper/save' , [TrakrViewController::class , 'stepperSave'])->name('stepperSave');
	
});

Route::prefix('support')->middleware(['auth', 'verified'])->group(function () {
	Route::get('/', [SupportController::class, 'index'])->name("support-index");
	Route::post('contact/add', [ContactController::class, 'contact'])->name("contact-store");
	Route::post('support/add', [SupportController::class, 'Supportstore'])->name("support-store");
	Route::get('support/edit/{id}', [SupportController::class, 'edit'])->name("support-edit");
	Route::post('support/update/{id}', [SupportController::class, 'update'])->name("support-update");
});

Route::prefix('reports')->middleware(['auth', 'verified'])->group(function () {
	Route::get('/', [ReportController::class, 'index'])->name("report-index");
	Route::get('/filter',[ReportController::class,'filter'])->name('report-filter');
	Route::get('/generate_list',[ReportController::class,'generate_pdf'])->name('list-report');
	Route::get('/summary' , [ReportController::class , 'summaryReport'])->name('summaryReport');
	Route::get('/summary/by/visitor' , [ReportController::class , 'byVisitor'])->name('byVisitor');
	Route::get('/summary/get/results/{question_id}/{log_id}' , [ReportController::class , 'viewResults'])->name('viewResults');
	Route::post('/summary/get/results/download/' , [ReportController::class , 'downloadResult'])->name('downloadResult');
	Route::get('/summary/search/results' , [ReportController::class , 'searchSummary'])->name('searchSummary');
});

Route::prefix('locations')->middleware(['auth'])->group(function() {
	Route::get('/', [LocationController::class, 'index'])->name("index");
	Route::get('/visit/{uuid}/{id}' , [LocationController::class , 'visit'])->name('visit');
	Route::get('/visit/show/visitor_logs/{user_id}/{visitor_id}' ,[LocationController::class,'visitorLogs'])->name('visitorLogs');
});

Route::prefix('user')->middleware(['auth', 'verified','isAdmin'])->group(function () {
	Route::get('/', [UserController::class, 'index'])->name('user-index');
	Route::get('/add', [UserController::class, 'add'])->name("user-add");
	Route::post('/add', [UserController::class, 'create'])->name("user-store");
	Route::get('/edit/{id}', [UserController::class, 'edit'])->name("user-edit");
	Route::post('/edit/{id}', [UserController::class, 'update'])->name("user-update");
	Route::get('/delete/{id}', [UserController::class, 'delete'])->name("user-delete");
	Route::get('/upload/{id}', [UploadImagesController::class, 'index'])->name('uploadimage-view');
	Route::post('/upload/{id}', [UploadImagesController::class, 'store'])->name('image-upload');	
});

Route::view('profile', 'profile.edit')
	->name('profile.edit')
	->middleware(['auth']);


