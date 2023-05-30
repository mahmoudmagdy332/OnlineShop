<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\loginController;
use App\Http\Controllers\Admin\dashboardController;
use App\Http\Controllers\Admin\LanguageController;
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

Route::group(['namespace'=>'Admin','prefix'=>'admin','middleware'=>'guest:admin'],function () {
    Route::get('/login',[loginController::class,'loginAdminVeiw'])->name('login.admin.view');
    Route::post('/login',[loginController::class,'login'])->name('admin.login');
});
Route::group(['namespace'=>'Admin','prefix'=>'admin','middleware'=>'auth:admin'],function () {
    Route::get('/',[dashboardController::class,'dashboardVeiw'])->name('admin.dashboard');
    Route::get('/logout',[dashboardController::class,'logout'])->name('admin.logout');

    ###############################languages routes###################################
    Route::group(['prefix'=>'languages'],function (){
        Route::get('/',[LanguageController::class,'index'])->name('admin.languages');
        Route::get('/add',[LanguageController::class,'get_add'])->name('get.add.admin.languages');
        Route::post('/add',[LanguageController::class,'store'])->name('admin.languages.store');
        Route::get('/edit/{id}',[LanguageController::class,'edit'])->name('admin.languages.edit');
        Route::post('/update/{id}',[LanguageController::class,'update'])->name('admin.languages.update');
        Route::get('/delete/{id}',[LanguageController::class,'delete'])->name('admin.languages.delete');
    });
    Route::get('/a',[LanguagesController::class,'index'])->name('admin.languages');
    #################################end languages routes###############################
});
