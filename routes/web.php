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
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\PembelianController;
use App\Http\Controllers\PenjualanController;
use App\Http\Controllers\AkunKasController;
use App\Http\Controllers\TransaksiKasController;
use App\Http\Controllers\ReportController;
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

Route::post('/validate', [LoginController::class, 'ValidateCompany'])->name('validate');
// Master
Route::get('/setting', [CompanySettingController::class, 'companysetting'])->name('setting')->middleware('auth');
Route::post('/setting/store', [CompanySettingController::class, 'setting_store'])->name('setting-store')->middleware('auth');
Route::get('/genpass/{pass}', [LoginController::class,'register'])->name('register');
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
Route::post('/databatch', [DataObatController::class,'DataBatch_View'])->name('databatch')->middleware('auth');
Route::get('/dataobat/form/{id}', [DataObatController::class,'DataObat_Form'])->name('dataobat-form')->middleware('auth');
Route::get('/dataobat/detail/{id}', [DataObatController::class,'DataObat_Detail'])->name('dataobat-detail')->middleware('auth');
Route::post('/dataobat/store', [DataObatController::class, 'store'])->name('dataobat-store')->middleware('auth');
Route::post('/dataobat/edit', [DataObatController::class, 'edit'])->name('dataobat-edit')->middleware('auth');
Route::delete('/dataobat/delete/{id}', [DataObatController::class, 'DataObat_delete'])->name('dataobat-delete')->middleware('auth');
Route::post('/dataobat/obatLookup', [DataObatController::class, 'obatLookup'])->name('obatLookup')->middleware('auth');
Route::post('/dataobat/batchLookup', [DataObatController::class, 'lookupBatch'])->name('batchLookup')->middleware('auth');
Route::post('/dataobat/getstockcard', [DataObatController::class, 'StockCard'])->name('getstockcard')->middleware('auth');
Route::post('/dataobat/listobat', [DataObatController::class, 'listObat'])->name('listobat')->middleware('auth');

/*
|--------------------------------------------------------------------------
| Supplier
|--------------------------------------------------------------------------
|
*/
Route::get('/supplier', [SupplierController::class,'SupplierView'])->name('supplier')->middleware('auth');
Route::get('/supplier/form/{id}', [SupplierController::class,'Supplier_Form'])->name('supplier-form')->middleware('auth');
Route::post('/supplier/store', [SupplierController::class, 'store'])->name('supplier-store')->middleware('auth');
Route::post('/supplier/edit', [SupplierController::class, 'edit'])->name('supplier-edit')->middleware('auth');
Route::delete('/supplier/delete/{id}', [SupplierController::class, 'Supplier_delete'])->name('supplier-delete')->middleware('auth');

/*
|--------------------------------------------------------------------------
| Customer
|--------------------------------------------------------------------------
|
*/
Route::get('/customer', [CustomerController::class,'CustomerView'])->name('customer')->middleware('auth');
Route::get('/customer/form/{id}', [CustomerController::class,'Customer_Form'])->name('customer-form')->middleware('auth');
Route::post('/customer/store', [CustomerController::class, 'store'])->name('customer-store')->middleware('auth');
Route::post('/customer/edit', [CustomerController::class, 'edit'])->name('customer-edit')->middleware('auth');
Route::delete('/customer/delete/{id}', [CustomerController::class, 'Customer_delete'])->name('customer-delete')->middleware('auth');


/*
|--------------------------------------------------------------------------
| Pembelian
|--------------------------------------------------------------------------
|
*/
Route::get('/pembelian', [PembelianController::class,'PembelianView'])->name('pembelian')->middleware('auth');
Route::post('/pembelian/getheader', [PembelianController::class,'PembelianHeaderShow'])->name('getheader')->middleware('auth');
Route::post('/pembelian/getdetail', [PembelianController::class,'PembelianDetailShow'])->name('getdetail')->middleware('auth');
Route::post('/pembelian/getreport', [PembelianController::class,'PembelianReport'])->name('getreport')->middleware('auth');
Route::post('/pembelian/store', [PembelianController::class, 'store'])->name('pembelian-store')->middleware('auth');
Route::post('/pembelian/edit', [PembelianController::class, 'edit'])->name('pembelian-edit')->middleware('auth');
Route::get('/pembelian/form/{id}', [PembelianController::class,'Pembelian_Form'])->name('pembelian-form')->middleware('auth');
Route::post('/pembelian/store', [PembelianController::class, 'store'])->name('pembelian-store')->middleware('auth');
Route::delete('/pembelian/cancel/{id}', [PembelianController::class,'CancelDocument'])->name('pembelian-cancel')->middleware('auth'); 	
Route::post('/pembelian/bayar', [PembelianController::class, 'Bayar'])->name('pembelian-bayar')->middleware('auth');

/*
|--------------------------------------------------------------------------
| Penjualan
|--------------------------------------------------------------------------
|
*/
Route::get('/penjualan', [PenjualanController::class,'PenjualanView'])->name('penjualan')->middleware('auth');
Route::post('/penjualan/getheader', [PenjualanController::class,'PenjualanHeaderShow'])->name('getheader')->middleware('auth');
Route::post('/penjualan/getdetail', [PenjualanController::class,'PenjualanDetailShow'])->name('getdetail')->middleware('auth');
Route::post('/penjualan/getreport', [PenjualanController::class,'PenjualanReport'])->name('getreportpenjualan')->middleware('auth');
Route::post('/penjualan/store', [PenjualanController::class, 'store'])->name('penjualan-store')->middleware('auth');
Route::post('/penjualan/edit', [PenjualanController::class, 'edit'])->name('penjualan-edit')->middleware('auth');
Route::get('/penjualan/form/{id}', [PenjualanController::class,'Penjualan_Form'])->name('penjualan-form')->middleware('auth');
Route::post('/penjualan/store', [PenjualanController::class, 'store'])->name('penjualan-store')->middleware('auth');
Route::delete('/penjualan/cancel/{id}', [PenjualanController::class,'CancelDocument'])->name('penjualan-cancel')->middleware('auth'); 	
Route::post('/penjualan/bayar', [PenjualanController::class, 'Bayar'])->name('penjualan-bayar')->middleware('auth');

/*
|--------------------------------------------------------------------------
| Kelompok Akun
|--------------------------------------------------------------------------
|
*/
Route::get('/akunkas', [AkunKasController::class,'AkunKasView'])->name('akunkas')->middleware('auth');
Route::get('/akunkas/form/{id}', [AkunKasController::class,'AkunKas_Form'])->name('akunkas-form')->middleware('auth');
Route::post('/akunkas/store', [AkunKasController::class, 'store'])->name('akunkas-store')->middleware('auth');
Route::post('/akunkas/edit', [AkunKasController::class, 'edit'])->name('akunkas-edit')->middleware('auth');
Route::delete('/akunkas/delete/{id}', [AkunKasController::class, 'akunkas_delete'])->name('akunkas-delete')->middleware('auth');

/*
|--------------------------------------------------------------------------
| Transaksi Kas
|--------------------------------------------------------------------------
|
*/
Route::get('/transaksikas', [TransaksiKasController::class,'TransaksiKasView'])->name('transaksikas')->middleware('auth');
Route::get('/transaksikas/form/{id}', [TransaksiKasController::class,'TransaksiKas_Form'])->name('transaksikas-form')->middleware('auth');
Route::post('/transaksikas/store', [TransaksiKasController::class, 'store'])->name('transaksikas-store')->middleware('auth');
Route::post('/transaksikas/edit', [TransaksiKasController::class, 'edit'])->name('transaksikas-edit')->middleware('auth');
Route::delete('/transaksikas/delete/{id}', [TransaksiKasController::class, 'TransaksiKas_delete'])->name('transaksikas-delete')->middleware('auth');
Route::post('/transaksikas/readreport', [TransaksiKasController::class, 'ReportKas'])->name('reportkas')->middleware('auth');

/*
|--------------------------------------------------------------------------
| Laporan
|--------------------------------------------------------------------------
|
*/
Route::get('/report/kartustock', [ReportController::class,'KartuStockView'])->name('rptkartustock')->middleware('auth');
Route::get('/report/saldostock', [ReportController::class,'SaldoStockView'])->name('rptsaldostock')->middleware('auth');
Route::get('/report/penjualan', [ReportController::class,'LaporanPenjualanView'])->name('rptpenjualan')->middleware('auth');
Route::get('/report/pembelian', [ReportController::class,'LaporanPembalianView'])->name('rptpembelian')->middleware('auth');
Route::get('/report/kas', [ReportController::class,'LaporanKasView'])->name('rptkas')->middleware('auth');