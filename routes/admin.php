<?php 
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\ClientAccessController;
use App\Http\Controllers\Admin\TemplateController;
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
	// Templates
	Route::get('/templates' , [TemplateController::class , 'index'])->name('template-index');
	Route::get('/templates/add' , [TemplateController::class , 'addView'])->name('addView');
	Route::post('/templates/save' , [TemplateController::class , 'save_new_notifications'])->name('saveNotif');
	Route::get('/templates/edit/{template_id}' , [TemplateController::class , 'notificationedit'])->name('editNotif');
	Route::get('/templates/save/{template_id}' , [TemplateController::class , 'notificatioSaveEdit'])->name('saveEditNotif');
	Route::get('/templates/question/new' , [TemplateController::class , 'questionView'])->name('questionView');
	Route::post('/templates/question/save' , [TemplateController::class , 'questionSave'])->name('questionSave');
	Route::get('/templates/edit/questionnaire/{id}' , [TemplateController::class , 'questionEditView'])->name('questionEditView');
	Route::post('/templates/save/questionnaire/{id}' , [TemplateController::class , 'questionEditSave'])->name('questionEditSave');
	Route::get('/templates/remove/{template_id}' , [TemplateController::class , 'templateRemove'])->name('templateRemove');
});