<?php 
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\AdminTrakrController;
use App\Http\Controllers\Admin\ClientAccessController;
use Illuminate\Support\Facades\Route;

Route::prefix('admin')->middleware(['auth' , 'isAdmin'])->group(function(){
	Route::get('/dashboard' ,[AdminController::class , 'index'])->name('admin-index');
	Route::get('/clients' ,[AdminController::class , 'clients'])->name('admin-clients');
	Route::get('/clients/add' ,[AdminController::class , 'newClient'])->name('admin-new-clients');
	Route::post('/clients/add' ,[AdminController::class , 'newClientSave'])->name('admin-save-clients');
	Route::get('/client/edit/{id}' , [AdminController::class , 'editClient'])->name('admin-edit-client');
	Route::post('/client/update/{id}' , [AdminController::class , 'updateClient'])->name('admin-update-client');
	Route::get('/client/remove/{id}' , [AdminController::class , 'removeClient'])->name('removeClient');
	Route::get('/client/add-image/{id}' , [AdminController::class , 'uploadImageView'])->name('uploadImageView');
	Route::post('/client/add-image/{id}' , [AdminController::class , 'uploadClientImage'])->name('uploadClientImage');

	Route::get('/trakrid' , [AdminTrakrController::class , 'index'])->name('admin-trakrid');
	Route::get('/trakrid/edit/{trakr}' , [AdminTrakrController::class , 'edit'])->name('admin-trakr-edit');
	Route::get('/trakrid/delete/{trakr}' , [AdminTrakrController::class , 'destroy'])->name('admin-trakr-delete');
	Route::post('/trakrid/edit/{trakr}', [AdminTrakrController::class, 'update'])->name("admin-trakr-update");
	Route::post('/trakrid/manual/visitor/signout' , [AdminTrakrController::class , 'manualSignOut'])->name('admin-manualSignOut');

	// Route::get('/', [ReportController::class, 'index'])->name("report-index");
	// Route::get('/summary' , [ReportController::class , 'summaryReport'])->name('summaryReport');
	
	// Route::get('/', [ReportController::class, 'index'])->name("report-index");
	// Route::get('/filter',[ReportController::class,'filter'])->name('report-filter');
	// Route::get('/generate_list',[ReportController::class,'generate_pdf'])->name('list-report');
	// Route::get('/summary' , [ReportController::class , 'summaryReport'])->name('summaryReport');
	// Route::get('/summary/by/visitor' , [ReportController::class , 'byVisitor'])->name('byVisitor');
	// Route::get('/summary/get/results/{question_id}/{log_id}' , [ReportController::class , 'viewResults'])->name('viewResults');
	// Route::post('/summary/get/results/download/' , [ReportController::class , 'downloadResult'])->name('downloadResult');
});