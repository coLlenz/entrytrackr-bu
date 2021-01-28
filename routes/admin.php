<?php 
use App\Http\Controllers\AdminController;
use Illuminate\Support\Facades\Route;

Route::prefix('admin')->middleware(['auth' , 'isAdmin'])->group(function(){
	Route::get('/dashboard' ,[AdminController::class , 'index'])->name('admin-index');
	Route::get('/clients' ,[AdminController::class , 'clients'])->name('admin-clients');
});