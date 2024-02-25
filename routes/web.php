<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\LoginController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\CompanySettingController;
use App\Http\Controllers\KategoriCustomerController;
use App\Http\Controllers\KategoriObatController;
use App\Http\Controllers\TerapiObatController;
use App\Http\Controllers\SatuanController;
use App\Http\Controllers\LokasiController;
use App\Http\Controllers\ShiftController;
use App\Http\Controllers\KaryawanController;
use App\Http\Controllers\MetodePembayaranController;
use App\Http\Controllers\DataObatController;
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

/*
|--------------------------------------------------------------------------
| Lokasi Rak
|--------------------------------------------------------------------------
|
*/
Route::get('/lokasi', [LokasiController::class,'LokasiView'])->name('lokasi')->middleware('auth');
Route::get('/lokasi/form/{id}', [LokasiController::class,'Lokasi_Form'])->name('lokasi-form')->middleware('auth');
Route::post('/lokasi/store', [LokasiController::class, 'store'])->name('lokasi-store')->middleware('auth');
Route::post('/lokasi/edit', [LokasiController::class, 'edit'])->name('lokasi-edit')->middleware('auth');
Route::delete('/lokasi/delete/{id}', [LokasiController::class, 'lokasi_delete'])->name('lokasi-delete')->middleware('auth');


/*
|--------------------------------------------------------------------------
| Shift
|--------------------------------------------------------------------------
|
*/
Route::get('/shift', [ShiftController::class,'ShiftView'])->name('shift')->middleware('auth');
Route::get('/shift/form/{id}', [ShiftController::class,'Shift_Form'])->name('shift-form')->middleware('auth');
Route::post('/shift/store', [ShiftController::class, 'store'])->name('shift-store')->middleware('auth');
Route::post('/shift/edit', [ShiftController::class, 'edit'])->name('shift-edit')->middleware('auth');
Route::delete('/shift/delete/{id}', [ShiftController::class, 'shift_delete'])->name('shift-delete')->middleware('auth');

/*
|--------------------------------------------------------------------------
| Karyawan
|--------------------------------------------------------------------------
|
*/
Route::get('/karyawan', [KaryawanController::class,'KaryawanView'])->name('karyawan')->middleware('auth');
Route::get('/karyawan/form/{id}', [KaryawanController::class,'Karyawan_Form'])->name('karyawan-form')->middleware('auth');
Route::post('/karyawan/store', [KaryawanController::class, 'store'])->name('karyawan-store')->middleware('auth');
Route::post('/karyawan/edit', [KaryawanController::class, 'edit'])->name('karyawan-edit')->middleware('auth');
Route::delete('/karyawan/delete/{id}', [KaryawanController::class, 'Karyawan_delete'])->name('karyawan-delete')->middleware('auth');

/*
|--------------------------------------------------------------------------
| Metode Pembayaran
|--------------------------------------------------------------------------
|
*/
Route::get('/metodepembayaran', [MetodePembayaranController::class,'MetodePembayaranView'])->name('metodepembayaran')->middleware('auth');
Route::get('/metodepembayaran/form/{id}', [MetodePembayaranController::class,'MetodePembayaran_Form'])->name('metodepembayaran-form')->middleware('auth');
Route::post('/metodepembayaran/store', [MetodePembayaranController::class, 'store'])->name('metodepembayaran-store')->middleware('auth');
Route::post('/metodepembayaran/edit', [MetodePembayaranController::class, 'edit'])->name('metodepembayaran-edit')->middleware('auth');
Route::delete('/metodepembayaran/delete/{id}', [MetodePembayaranController::class, 'MetodePembayaran_delete'])->name('metodepembayaran-delete')->middleware('auth');


/*
|--------------------------------------------------------------------------
| Data Obat
|--------------------------------------------------------------------------
|
*/
Route::get('/dataobat', [DataObatController::class,'DataObatView'])->name('dataobat')->middleware('auth');
Route::get('/dataobat/form/{id}', [DataObatController::class,'DataObat_Form'])->name('dataobat-form')->middleware('auth');
Route::post('/dataobat/store', [DataObatController::class, 'store'])->name('dataobat-store')->middleware('auth');
Route::post('/dataobat/edit', [DataObatController::class, 'edit'])->name('dataobat-edit')->middleware('auth');
Route::delete('/dataobat/delete/{id}', [DataObatController::class, 'DataObat_delete'])->name('dataobat-delete')->middleware('auth');