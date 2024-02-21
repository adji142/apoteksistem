<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\LoginController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\CompanySettingController;
use App\Http\Controllers\KategoriCustomerController;
use App\Http\Controllers\KategoriObatController;
use App\Http\Controllers\TerapiObatController;
use App\Http\Controllers\SatuanController;
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

Route::get('/', [LoginController::class,'login'])->name('login');
Route::post('/action-login', [LoginController::class, 'action_login'])->name('action-login');
Route::get('/dashboard', [DashboardController::class, 'dashboard'])->name('dashboard')->middleware('auth');
Route::get('/logout', [LoginController::class, 'logout'])->name('logout')->middleware('auth');

// Master
Route::get('/setting', [CompanySettingController::class, 'companysetting'])->name('setting')->middleware('auth');
Route::post('/setting/store', [CompanySettingController::class, 'setting_store'])->name('setting-store')->middleware('auth');

// Route::get('/kategoricustomer', [KategoriCustomerController::class, 'KategoriCustomer'])->name('kategoricustomer')->middleware('auth');
// Route::post('/kategoricustomer-read', [KategoriCustomerController::class, 'Read'])->name('kategoricustomer-read');

/*
|--------------------------------------------------------------------------
| Kategori Customer
|--------------------------------------------------------------------------
|
*/
Route::get('/kategoricustomer', [KategoriCustomerController::class,'KategoriCustomer'])->name('kategoricustomer')->middleware('auth');
Route::get('/kategoricustomer/form/{id}', [KategoriCustomerController::class,'KategoriCustomer_form'])->name('kategori-form')->middleware('auth');
Route::post('/kategoricustomer/store', [KategoriCustomerController::class, 'store'])->name('kategori-store')->middleware('auth');
Route::post('/kategoricustomer/edit', [KategoriCustomerController::class, 'edit'])->name('kategori-edit')->middleware('auth');
Route::delete('/kategoricustomer/delete/{id}', [KategoriCustomerController::class, 'kategoricustomer_delete'])->name('kategoricustomer-delete')->middleware('auth');


/*
|--------------------------------------------------------------------------
| Kategori Obat
|--------------------------------------------------------------------------
|
*/
Route::get('/kategoriobat', [KategoriObatController::class,'i_KategoriObat'])->name('kategoriobat')->middleware('auth');
Route::get('/kategoriobat/form/{id}', [KategoriObatController::class,'KategoriObat_form'])->name('kategoriobat-form')->middleware('auth');
Route::post('/kategoriobat/store', [KategoriObatController::class, 'store'])->name('kategoriobat-store')->middleware('auth');
Route::post('/kategoriobat/edit', [KategoriObatController::class, 'edit'])->name('kategoriobat-edit')->middleware('auth');
Route::delete('/kategoriobat/delete/{id}', [KategoriObatController::class, 'kategoriobat_delete'])->name('kategoriobat-delete')->middleware('auth');

/*
|--------------------------------------------------------------------------
| Terapi Obat
|--------------------------------------------------------------------------
|
*/
Route::get('/terapiobat', [TerapiObatController::class,'TerapiObatView'])->name('terapiobat')->middleware('auth');
Route::get('/terapiobat/form/{id}', [TerapiObatController::class,'TerapiObat_Form'])->name('terapiobat-form')->middleware('auth');
Route::post('/terapiobat/store', [TerapiObatController::class, 'store'])->name('terapiobat-store')->middleware('auth');
Route::post('/terapiobat/edit', [TerapiObatController::class, 'edit'])->name('terapiobat-edit')->middleware('auth');
Route::delete('/terapiobat/delete/{id}', [TerapiObatController::class, 'terapiobat_delete'])->name('terapiobat-delete')->middleware('auth');

/*
|--------------------------------------------------------------------------
| Satuan
|--------------------------------------------------------------------------
|
*/
Route::get('/satuan', [SatuanController::class,'SatuanView'])->name('satuan')->middleware('auth');
Route::get('/satuan/form/{id}', [SatuanController::class,'Satuan_Form'])->name('satuan-form')->middleware('auth');
Route::post('/satuan/store', [SatuanController::class, 'store'])->name('satuan-store')->middleware('auth');
Route::post('/satuan/edit', [SatuanController::class, 'edit'])->name('satuan-edit')->middleware('auth');
Route::delete('/satuan/delete/{id}', [SatuanController::class, 'satuan_delete'])->name('satuan-delete')->middleware('auth');