<?php 
use App\Http\Controllers\TrakrController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\TemplateController;
use App\Http\Controllers\ReportController;
use Illuminate\Support\Facades\Route;

Route::prefix('admin')->middleware(['auth' , 'isAdmin'])->group(function(){
	Route::get('/dashboard' ,[AdminController::class , 'index'])->name('admin-index');
	Route::get('/clients' ,[AdminController::class , 'clients'])->name('admin-clients');
	Route::get('/clients/add' ,[AdminController::class , 'newClient'])->name('admin-new-clients');
	Route::post('/clients/add' ,[AdminController::class , 'newClientSave'])->name('admin-save-clients');
	Route::get('/client/edit/{id}' , [AdminController::class , 'editClient'])->name('admin-edit-client');
	Route::post('/client/update/{id}' , [AdminController::class , 'updateClient'])->name('admin-update-client');

	// Route::get('/trakrid' ,[TrakrController::class , 'adminIndex'])->name('admin-index');
	// Route::get('/templates' ,[TemplateController::class , 'index'])->name('admin-index');
	// Route::get('/reports' ,[ReportController::class , 'index'])->name('admin-index');
	// Route::get('/reports/summary' ,[ReportController::class , 'summaryReport'])->name('summaryReport');
	// Route::get('/trakrid/add' ,[TrakrController::class , 'index'])->name('trakr-add');

	// Route::prefix('trakrid')->middleware(['auth', 'verified'])->group(function () {
	// 	Route::get('/', [TrakrController::class, 'index'])->name("trakr-index");
	// 	Route::get('/add', [TrakrController::class, 'create'])->name("trakr-add");
	// 	Route::post('/add', [TrakrController::class, 'store'])->name("trakr-store");
	// 	Route::get('/edit/{trakr}', [TrakrController::class, 'edit'])->name("trakr-edit");
	// 	Route::post('/edit/{trakr}', [TrakrController::class, 'update'])->name("trakr-update");
	// 	Route::get('/delete/{trakr}', [TrakrController::class, 'destroy'])->name("trakr-delete");
	// 	// Safe CheckBox
	// 	Route::post('update/safe', [TrakrController::class, 'safeupdate'])->name("trakr-safe");
	// 	// manual sign out
	// 	Route::post('manual/visitor/signout' , [TrakrController::class , 'manualSignOut'])->name('manualSignOut');
	// });
});