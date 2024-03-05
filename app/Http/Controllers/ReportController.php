<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use DB;
use Log;

use App\Models\DataObat;
class ReportController extends Controller
{
    public function KartuStockView(Request $request){
    	$dataobat = DataObat::where('RecordOwnerID','=',Auth::user()->RecordOwnerID)->get();
    	return view("report.kartustock",[
    		'dataobat' => $dataobat
    	]);
    }
    public function SaldoStockView(Request $request){
    	return view("report.saldostock");
    }
    public function LaporanPenjualanView(Request $request){
    	return view("report.laporanpenjualan");
    }
    public function LaporanPembalianView(Request $request){
    	return view("report.laporanpembelian");
    }
    public function LaporanKasView(Request $request){
        return view("report.laporankas");
    }
}
