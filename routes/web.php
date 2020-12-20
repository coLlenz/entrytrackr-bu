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
use App\Models;
use Illuminate\Support\Facades\Route;
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

Route::get('dashboard', [DashboardController::class, 'index'])
	->name('home')
	->middleware(['auth', 'verified']);
Route::get('/generate_pdf' , [DashboardController::class , 'generate_pdf'])
	->middleware(['auth'])
	->name('generate_pdf');
	
Route::prefix('settings')->middleware(['auth', 'verified'])->group(function () {
	Route::view('/', 'profile.show')->name('profile');
	Route::view('/changepassword', 'profile.update_password')->name('profile-update');
	Route::post('/add_admin' , [SettingsController::class , 'new_admin'])->name('add-new-admin');
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
});
Route::prefix('templates')->middleware(['auth', 'verified'])->group(function () {
	Route::get('/', [TemplateController::class, 'index'])->name("template-index");
	Route::get('/notification-add', [TemplateController::class, 'notificationcreate'])->name("notification-add");
	Route::get('/notification-edit/{id}', [TemplateController::class, 'notificationedit'])->name("notification-edit");
	Route::post('/notification-edit/{id}', [TemplateController::class, 'notificationupdate'])->name("notification-update");
	Route::get('/form-add', [TemplateController::class, 'formcreate'])->name("form-add");
	Route::post('/form-add', [TemplateController::class, 'formstore'])->name("form-store");
	Route::get('/form-edit/{id}', [TemplateController::class, 'formedit'])->name("form-edit");
	Route::post('/form-edit/{id}', [TemplateController::class, 'formupdate'])->name("form-update");
	Route::get('/activate/{id}', [TemplateController::class, 'activate'])->name("activate");
	Route::get('/deactivate/{id}', [TemplateController::class, 'deactivate'])->name("deactivate");
	Route::post('/add', [TemplateController::class, 'store'])->name("template-store");
	Route::get('/edit/{template}', [TemplateController::class, 'edit'])->name("template-edit");
	Route::post('/edit/{template}', [TemplateController::class, 'update'])->name("template-update");
	Route::get('/delete/{template}', [TemplateController::class, 'destroy'])->name("template-delete");
});
Route::prefix('trakr')->group(function () {
	Route::get('/{id}/visitor-checkin', [TrakrViewController::class, 'index'])->name("trakr-view");
	Route::post('/{id}/visitor-checkin', [TrakrViewController::class, 'create'])->name("trakr-post");
	Route::post('/trakrid/check', [TrakrViewController::class, 'trakrid'])->name("trakrid-post");
	Route::post('/trakrid/checkout', [TrakrViewController::class, 'trakrcheckout'])->name("trakrid-signout");
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
});
Route::prefix('user')->middleware(['auth', 'verified','isAdmin'])->group(function () {
	Route::get('/', [UserController::class, 'index'])->name('user-index');
	Route::get('/add', [UserController::class, 'add'])->name("user-add");
	Route::post('/add', [UserController::class, 'create'])->name("user-store");
	Route::get('/edit/{id}', [UserController::class, 'edit'])->name("user-edit");
	Route::post('/edit/{id}', [UserController::class, 'update'])->name("user-update");
	Route::get('/delete/{id}', [UserController::class, 'delete'])->name("user-delete");
});
Route::view('profile', 'profile.edit')
	->name('profile.edit')
	->middleware(['auth']);


