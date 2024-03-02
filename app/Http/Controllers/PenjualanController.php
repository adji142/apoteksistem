<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use DB;
use Log;

use App\Models\MetodePembayaran;
use App\Models\PenjualanHeader;
use App\Models\PenjualanDetail;
use App\Models\Customer;
use App\Models\ItemWarehouse;
use App\Models\DataPembayaran;
use App\Models\BatchNumber;

class PenjualanController extends Controller
{
    public function PenjualanView(Request $request)
    {

    	$customer = Customer::where('RecordOwnerID','=',Auth::user()->RecordOwnerID)
    				->where('Active','=',1)->get();
        $metode = MetodePembayaran::where('RecordOwnerID','=',Auth::user()->RecordOwnerID)->get();

        $title = 'Cancel Dokumen Penjualan !';
        $text = "Are you sure you want to delete ?";
        confirmDelete($title, $text);

        return view("transaksi.penjualan.penjualan",[
        	'customer' => $customer,
            'metode' =>$metode
       	]);
    }

    public function PenjualanHeaderShow(Request $request)
    {
    	$data = array('success' => true, 'message'=>'', 'data' => array());

    	$TglAwal = $request->input('TglAwal');
    	$TglAkhir = $request->input('TglAkhir');
    	$Supplier = $request->input('Supplier');
    	$RecordOwnerID = Auth::user()->RecordOwnerID;

    	$sql ="penjualanheader.NoTransaksi, penjualanheader.TglTransaksi, customer.NamaCustomer, CASE WHEN penjualanheader.StatusTRX = 'O' THEN 'OPEN' ELSE CASE WHEN penjualanheader.StatusTRX ='C' THEN 'CLOSE' ELSE CASE WHEN penjualanheader.StatusTRX = 'N' THEN 'CANCEL' ELSE '' END END END AS StatusTRX, penjualanheader.DocTotal, CASE WHEN penjualanheader.DocTotal <= COALESCE(stk.Total,0) THEN 'LUNAS' ELSE 'BELUM LUNAS' END AS StatusBayar, penjualanheader.DocTotal, COALESCE(stk.Total,0) as Pembayaran ";
    	$header = PenjualanHeader::selectRaw($sql)
    				->leftJoin('customer', function ($value)
    				{
    					$value->on('penjualanheader.RecordOwnerID','=','customer.RecordOwnerID')
    					->on('penjualanheader.KodeCustomer','=','customer.id');
    				})
                    ->leftJoinSub(
                        DB::table('datapembayaran')
                            ->selectRaw("datapembayaran.NoTransaksi,datapembayaran.RecordOwnerID,group_concat(datapembayaran.NoReffPembayaran) NoReff, group_concat(metodepembayaran.NamaMetodePembayaran) MetodePembayaran, SUM(datapembayaran.TotalPembayaran) Total")
                            ->leftJoin('metodepembayaran', function ($value)
                            {
                                $value->on('metodepembayaran.id','=','datapembayaran.KodeMetodePembayaran')
                                ->on('metodepembayaran.RecordOwnerID','=','datapembayaran.RecordOwnerID');
                            })
                            ->groupBy('datapembayaran.NoTransaksi','datapembayaran.RecordOwnerID'),
                        'stk',
                        function ($value){
                            $value->on('stk.NoTransaksi','=','penjualanheader.NoTransaksi')
                                    ->on('stk.RecordOwnerID','=','penjualanheader.RecordOwnerID');
                    })
                    ->whereBetween('TglTransaksi',[$TglAwal, $TglAkhir])
    				->where('penjualanheader.RecordOwnerID','=', Auth::user()->RecordOwnerID);

        if ($Supplier != "") {
            $header->where('penjualanheader.KodeCustomer','=', $Supplier);
        }
        $header->orderBy('penjualanheader.TglTransaksi', 'DESC');

        $data['data'] = $header->get();

        return response()->json($data);
    }

    public function PenjualanReport(Request $request)
    {
        $data = array('success' => true, 'message'=>'', 'data' => array());

        $TglAwal = $request->input('TglAwal');
        $TglAkhir = $request->input('TglAkhir');
        $Customer = $request->input('Customer');
        $KodeItem = $request->input('KodeItem');
        $RecordOwnerID = Auth::user()->RecordOwnerID;

        $sql ="penjualanheader.NoTransaksi, penjualanheader.TglTransaksi, customer.NamaCustomer, CASE WHEN penjualanheader.StatusTRX = 'O' THEN 'OPEN' ELSE CASE WHEN penjualanheader.StatusTRX ='C' THEN 'CLOSE' ELSE CASE WHEN penjualanheader.StatusTRX = 'N' THEN 'CANCEL' ELSE '' END END END AS StatusTRX, penjualanheader.DocTotal, CASE WHEN penjualanheader.DocTotal <= COALESCE(stk.Total,0) THEN 'LUNAS' ELSE 'BELUM LUNAS' END AS StatusBayar, penjualanheader.DocTotal, COALESCE(stk.Total,0) as Pembayaran, penjualandetail.Qty ";
        $header = PenjualanHeader::selectRaw($sql)
                    ->leftJoin('customer', function ($value)
                    {
                        $value->on('penjualanheader.RecordOwnerID','=','customer.RecordOwnerID')
                        ->on('penjualanheader.KodeCustomer','=','customer.id');
                    })
                    ->leftJoinSub(
                        DB::table('datapembayaran')
                            ->selectRaw("datapembayaran.NoTransaksi,datapembayaran.RecordOwnerID,group_concat(datapembayaran.NoReffPembayaran) NoReff, group_concat(metodepembayaran.NamaMetodePembayaran) MetodePembayaran, SUM(datapembayaran.TotalPembayaran) Total")
                            ->leftJoin('metodepembayaran', function ($value)
                            {
                                $value->on('metodepembayaran.id','=','datapembayaran.KodeMetodePembayaran')
                                ->on('metodepembayaran.RecordOwnerID','=','datapembayaran.RecordOwnerID');
                            })
                            ->groupBy('datapembayaran.NoTransaksi','datapembayaran.RecordOwnerID'),
                        'stk',
                        function ($value){
                            $value->on('stk.NoTransaksi','=','penjualanheader.NoTransaksi')
                                    ->on('stk.RecordOwnerID','=','penjualanheader.RecordOwnerID');
                    })
                    ->leftJoin('penjualandetail', function ($value)
                    {
                        $value->on('penjualandetail.NoTransaksi','=','penjualanheader.NoTransaksi')
                        ->on('penjualandetail.RecordOwnerID','=','penjualanheader.RecordOwnerID');
                    })
                    ->whereBetween('TglTransaksi',[$TglAwal, $TglAkhir])
                    ->where('penjualanheader.RecordOwnerID','=', Auth::user()->RecordOwnerID);

        if ($Customer != "") {
            $header->where('penjualanheader.KodeCustomer','=', $Customer);
        }
        if ($KodeItem != "") {
            $header->where('penjualandetail.KodeItem','=', $KodeItem);
        }
        $header->orderBy('penjualanheader.TglTransaksi', 'DESC');

        $data['data'] = $header->get();

        return response()->json($data);
    }

    public function PenjualanDetailShow(Request $request)
    {
    	$data = array('success' => true, 'message'=>'', 'data' => array());

    	$NoTransaksi = $request->input('NoTransaksi');
    	$RecordOwnerID = Auth::user()->RecordOwnerID;

        $sql = "penjualandetail.LineNumber, penjualandetail.KodeItem,databarang.NamaItem,penjualandetail.BatchNumber, penjualandetail.Qty,satuan.Nama as satuan, penjualandetail.Harga, penjualandetail.Diskon, penjualandetail.LineTotal ";
        $detail = PenjualanDetail::selectRaw($sql)
                ->leftJoin('databarang', function ($value)
                {
                    $value->on('penjualandetail.KodeItem','=','databarang.KodeItem')
                    ->on('penjualandetail.RecordOwnerID','=','databarang.RecordOwnerID');
                })
                ->leftJoin('satuan', function ($value)
                {
                    $value->on('penjualandetail.KodeSatuan','=','satuan.Kode')
                    ->on('penjualandetail.RecordOwnerID','=','satuan.RecordOwnerID');
                })
                ->where('penjualandetail.NoTransaksi','=',$NoTransaksi)
                ->where('penjualandetail.RecordOwnerID','=', $RecordOwnerID)
                ->orderBy('penjualandetail.LineNumber','ASC');
        $data['data'] = $detail->get();

        return response()->json($data);
    }

    public function Penjualan_form($id = null)
    {
        $penjualan = array();
        $customer = Customer::where('RecordOwnerID','=',Auth::user()->RecordOwnerID)
                    ->where('Active','=',1)->get();
        $metode = MetodePembayaran::where('RecordOwnerID','=',Auth::user()->RecordOwnerID)->get();
        return view("transaksi.penjualan.penjualan-input",[
            'penjualan' => $penjualan,
            'customer' => $customer,
            'metode' => $metode
        ]);
    }
    public function store(Request $request)
    {
        $data = array('success' => false, 'message' => '', 'data' => array(), 'Kembalian' => "");

        $jsonData = $request->json()->all();
        // var_dump($jsonData['detail'][0]['LineNumber']);
        Log::debug($request->all());
        DB::beginTransaction();

        $errorCount = 0;

        try {
            // Generate NoTransaksi
            $NoTransaksi = "";
            $prefix = 'PJ'.substr(date('Ymd'),2,8);
            $lastNoTrx = PenjualanHeader::where('RecordOwnerID','=',Auth::user()->RecordOwnerID)
                            ->where(DB::raw('LEFT(NoTransaksi,8)'),'=',$prefix)->count()+1;
            $NoTransaksi = $prefix.str_pad($lastNoTrx, 4, '0', STR_PAD_LEFT);
            // Generate NoTransaksi

            $header = new PenjualanHeader;
            $header->NoTransaksi = $NoTransaksi;
            $header->TglTransaksi = $jsonData['header']['TglTransaksi'];
            $header->KodeCustomer = $jsonData['header']['KodeCustomer'];
            $header->StatusTransaksi = $jsonData['header']['StatusTRX'];
            $header->StatusTRX = $jsonData['header']['StatusTRX'];
            $header->CreatedBy = Auth::user()->name;
            $header->UpdatedBy = "";
            $header->RecordOwnerID = Auth::user()->RecordOwnerID;
            $header->DocTotal = 0;
            $header->Keterangan = "";

            $saveheader = $header->save();
            if ($saveheader) {
                if (count($jsonData['detail']) == 0) {
                    $data['message'] = "Data Item Belum dimasukan";
                    $errorCount +=1;
                    goto jump;
                }

                for ($i=0; $i < count($jsonData['detail']) ; $i++) {

                    if ($jsonData['detail'][$i]['Qty'] == 0) {
                        $data["message"] = "Item ".$jsonData['detail'][$i]['NamaItem']." Qty Tidak Boleh Kosong";
                        $errorCount +=1;
                        goto jump;
                    }

                    $itemwhs = ItemWarehouse::where('RecordOwnerID','=',Auth::user()->RecordOwnerID)
                                ->where('KodeItem','=',$jsonData['detail'][$i]['KodeItem'])->first();
                    if ($jsonData['detail'][$i]['Qty'] > $itemwhs->Qty) {
                        $data["message"] = "Item ".$jsonData['detail'][$i]['NamaItem']." Qty Tidak Cukup";
                        $errorCount +=1;
                        goto jump;
                    }

                    $itemBatch = DB::table('batchnumber')
                                    ->selectRaw('BatchNumber, SUM(Qty) StockBatch ')
                                    ->where('RecordOwnerID','=',Auth::user()->RecordOwnerID)
                                    ->where('BatchNumber','=',$jsonData['detail'][$i]['BatchNumber'])
                                    ->groupBy('BatchNumber')
                                    ->first();
                    if ($jsonData['detail'][$i]['Qty'] > $itemBatch->StockBatch) {
                        $data["message"] = "Batch  ".$jsonData['detail'][$i]['BatchNumber']." Qty Tidak Cukup";
                        $errorCount +=1;
                        goto jump;
                    }

                    $detail = new PenjualanDetail;
                    $detail->NoTransaksi = $NoTransaksi;
                    $detail->LineNumber = $i;
                    $detail->KodeItem = $jsonData['detail'][$i]['KodeItem'];
                    $detail->BatchNumber = $jsonData['detail'][$i]['BatchNumber'];
                    $detail->KodeSatuan = $jsonData['detail'][$i]['KodeSatuan'];
                    $detail->Qty = $jsonData['detail'][$i]['Qty'];
                    $detail->Harga = $jsonData['detail'][$i]['HargaJual'];
                    $detail->Potongan = $jsonData['detail'][$i]['LineTotal'] - ($jsonData['detail'][$i]['Qty'] * $jsonData['detail'][$i]['HargaJual']);
                    $detail->Diskon = $jsonData['detail'][$i]['Diskon'];
                    $detail->LineTotal = $jsonData['detail'][$i]['LineTotal'];
                    $detail->Keterangan = "";
                    $detail->CreatedBy = Auth::user()->name;
                    $detail->UpdatedBy = "";
                    $detail->RecordOwnerID = Auth::user()->RecordOwnerID;
                    $saveDetail = $detail->save();

                    if (!$saveDetail) {
                        $data['message'] = "Gagal Simpan Item Data";
                        $errorCount +=1;
                        goto jump;
                    }
                }   
            }

            // Bayar : 
            $bayar = new DataPembayaran;
            $bayar->KodeMetodePembayaran = $jsonData['pembayaran']['KodeMetodePembayaran'];
            $bayar->NoTransaksi = $NoTransaksi;
            $bayar->NoReffPembayaran = $jsonData['pembayaran']['NoReffPembayaran'];
            $bayar->TglPembayaran = $jsonData['pembayaran']['TglPembayaran'];
            $bayar->TotalPembayaran = $jsonData['pembayaran']['TotalPembayaran'];
            $bayar->RecordOwnerID = Auth::user()->RecordOwnerID;

            $savebayar = $bayar->save();

            $Kembalian =  $jsonData['pembayaran']['TotalPembayaran'] - $jsonData['pembayaran']['TotalTransaksi'];

            if (!$savebayar) {
                $data['message'] = "Pembayaran Gagal disimpan";
                $errorCount +=1;
                goto jump;
            }

            jump:
            if ($errorCount > 0) {
                DB::rollback();
                $data['success'] = false;
            }
            else{
                DB::commit();
                $data['Kembalian'] = $Kembalian;
                $data['success'] = true;
            }
        } catch (\Exception $e) {
            DB::rollback();
            $data['success'] = false;
            $data['message'] = $e->getMessage();
        }

        return response()->json($data);
    }
}
