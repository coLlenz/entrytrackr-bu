<?php 
use App\Http\Controllers\Admin\AdminController;
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
});