<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use DB;
use Log;

use App\Models\Supplier;
use App\Models\PembelianHeader;
use App\Models\PembelianDetail;

class PembelianController extends Controller
{
    public function PembelianView(Request $request)
    {

    	$supplier = Supplier::where('RecordOwnerID','=',Auth::user()->RecordOwnerID)
    				->where('Active','=',1)->get();
        return view("transaksi.pembelian.pembelian",[
        	'supplier' => $supplier
       	]);
    }

    public function PembelianHeaderShow(Request $request)
    {
    	$data = array('success' => true, 'message'=>'', 'data' => array());

    	$TglAwal = $request->input('TglAwal');
    	$TglAkhir = $request->input('TglAkhir');
    	$Supplier = $request->input('Supplier');
    	$RecordOwnerID = Auth::user()->RecordOwnerID;

    	$sql ="pembelianheader.NoTransaksi, pembelianheader.TglTransaksi, pembelianheader.TglJatuhTempo, supplier.NamaSupplier, pembelianheader.NoRef, CASE WHEN pembelianheader.StatusTRX = 'O' THEN 'OPEN' ELSE CASE WHEN pembelianheader.StatusTRX ='C' THEN 'CLOSE' ELSE CASE WHEN pembelianheader.StatusTRX = 'N' THEN 'CANCEL' ELSE '' END END END AS StatusTRX";
    	$header = PembelianHeader::selectRaw($sql)
    				->leftJoin('supplier', function ($value)
    				{
    					$value->on('pembelianheader.RecordOwnerID','=','supplier.RecordOwnerID')
    					->on('pembelianheader.KodeVendor','=','supplier.id');
    				})
                    ->whereBetween('TglTransaksi',[$TglAwal, $TglAkhir])
    				->where('pembelianheader.RecordOwnerID','=', Auth::user()->RecordOwnerID);

        if ($Supplier != "") {
            $header->where('pembelianheader.KodeVendor','=', $Supplier);
        }
        $header->orderBy('pembelianheader.TglTransaksi', 'DESC');

        $data['data'] = $header->get();

        return response()->json($data);
    }

    public function PembelianDetailShow(Request $request)
    {
    	$data = array('success' => true, 'message'=>'', 'data' => array());

    	$NoTransaksi = $request->input('NoTransaksi');
    	$RecordOwnerID = Auth::user()->RecordOwnerID;

        $sql = "pembeliandetail.LineNumber, pembeliandetail.KodeItem,databarang.NamaItem,pembeliandetail.BatchNumber, pembeliandetail.Qty,satuan.Nama as satuan, pembeliandetail.Harga, pembeliandetail.Diskon, pembeliandetail.LineTotal ";
        $detail = PembelianDetail::selectRaw($sql)
                ->leftJoin('databarang', function ($value)
                {
                    $value->on('pembeliandetail.KodeItem','=','databarang.KodeItem')
                    ->on('pembeliandetail.RecordOwnerID','=','databarang.RecordOwnerID');
                })
                ->leftJoin('satuan', function ($value)
                {
                    $value->on('pembeliandetail.KodeSatuan','=','satuan.Kode')
                    ->on('pembeliandetail.RecordOwnerID','=','satuan.RecordOwnerID');
                })
                ->where('pembeliandetail.NoTransaksi','=',$NoTransaksi)
                ->where('pembeliandetail.RecordOwnerID','=', $RecordOwnerID)
                ->orderBy('pembeliandetail.LineNumber','ASC');
        $data['data'] = $detail->get();

        return response()->json($data);
    }

    public function Pembelian_form($id = null)
    {
        $pembelian = array();
        $supplier = Supplier::where('RecordOwnerID','=',Auth::user()->RecordOwnerID)
                    ->where('Active','=',1)->get();
        return view("transaksi.pembelian.pembelian-input",[
            'pembelian' => $pembelian,
            'supplier' => $supplier
        ]);
    }
    public function store(Request $request)
    {
        $data = array('success' => false, 'message' => '', 'data' => array());

        $jsonData = $request->json()->all();
        // var_dump($jsonData['detail'][0]['LineNumber']);
        Log::debug($request->all());
        DB::beginTransaction();

        $errorCount = 0;

        try {
            // Generate NoTransaksi
            $NoTransaksi = "";
            $prefix = 'PB'.substr(date('Ymd'),2,8);
            $lastNoTrx = PembelianHeader::where('RecordOwnerID','=',Auth::user()->RecordOwnerID)
                            ->where(DB::raw('LEFT(NoTransaksi,8)'),'=',$prefix)->count()+1;
            $NoTransaksi = $prefix.str_pad($lastNoTrx, 4, '0', STR_PAD_LEFT);
            // Generate NoTransaksi

            $header = new PembelianHeader;
            $header->NoTransaksi = $NoTransaksi;
            $header->TglTransaksi = $jsonData['header']['TglTransaksi'];
            $header->TglJatuhTempo = $jsonData['header']['TglJatuhTempo'];
            $header->KodeVendor = $jsonData['header']['Supplier'];
            $header->NoRef = $jsonData['header']['NoRef'];
            $header->StatusTransaksi = $jsonData['header']['StatusTRX'];
            $header->Keterangan = $jsonData['header']['Keterangan'];
            $header->StatusTRX = $jsonData['header']['StatusTRX'];
            $header->CreatedBy = Auth::user()->name;
            $header->UpdatedBy = "";
            $header->RecordOwnerID = Auth::user()->RecordOwnerID;
            $header->DocTotal = 0;

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

                    $detail = new PembelianDetail;
                    $detail->NoTransaksi = $NoTransaksi;
                    $detail->LineNumber = $i;
                    $detail->KodeItem = $jsonData['detail'][$i]['KodeItem'];
                    $detail->BatchNumber = $jsonData['detail'][$i]['BatchNumber'];

                    $dateTime = $jsonData['detail'][$i]['ExpiredDate'];
                    $detail->ExpiredDate = date('Y-m-d', strtotime($dateTime));
                    $detail->KodeSatuan = $jsonData['detail'][$i]['KodeSatuan'];
                    $detail->Qty = $jsonData['detail'][$i]['Qty'];
                    $detail->Harga = $jsonData['detail'][$i]['Harga'];
                    $detail->Potongan = $jsonData['detail'][$i]['LineTotal'] - ($jsonData['detail'][$i]['Qty'] * $jsonData['detail'][$i]['Harga']);
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

            
            jump:
            if ($errorCount > 0) {
                DB::rollback();
                $data['success'] = false;
            }
            else{
                DB::commit();
                $data['success'] = true;
            }
        } catch (\Exception $e) {
            DB::rollback();
            $data['success'] = false;
            $data['message'] = $e->getMessage();
        }

        return response()->json($data);
    }
    public function edit(Request $request)
    {
        # code...
    }
}
