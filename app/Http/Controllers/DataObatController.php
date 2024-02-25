<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use DB;
use Log;

use App\Models\DataObat;
use App\Models\KategoriObat;
use App\Models\Lokasi;
use App\Models\Satuan;

class DataObatController extends Controller
{
    public function DataObatView(Request $request)
    {
    	$field = ['databarang.KodeItem','databarang.NamaItem'];
        $keyword = $request->input('keyword');
        $KodeKelompok = $request->input('KodeKelompok');
        $LokasiRakObat = $request->input('LokasiRakObat');
        $Status = $request->input('Status');

        $sql = "databarang.KodeItem, ".
        		"databarang.NamaItem, ".
        		"kategoriobat.Nama 		AS 'Kelompok', ".
        		"stk.Stock, ".
        		"satuan.Nama 			AS 'Satuan', ".
        		"databarang.HargaJual, ".
        		"lokasi.Nama 			AS LokasiRak";

        $dataobat = DataObat::selectRaw($sql)
        			->leftJoin('kategoriobat', function ($value){
        				$value->on('databarang.KodeKelompok','=','kategoriobat.id')
        						->on('databarang.RecordOwnerID','=','kategoriobat.RecordOwnerID');
        			})
        			->leftJoin('satuan', function ($value){
        				$value->on('databarang.KodeSatuan','=','satuan.Kode')
        						->on('databarang.RecordOwnerID','=','satuan.RecordOwnerID');
        			})
        			->leftJoin('lokasi', function ($value){
        				$value->on('databarang.LokasiRakObat','=','lokasi.Kode')
        						->on('databarang.RecordOwnerID','=','lokasi.RecordOwnerID');
        			})
        			->leftJoinSub(
        				DB::table('itemwarehouse')
        					->select('itemwarehouse.KodeItem','itemwarehouse.RecordOwnerID', DB::raw('SUM(Qty) as Stock'))
        					->groupBy('itemwarehouse.KodeItem','itemwarehouse.RecordOwnerID'),
        				'stk',
        				function ($value){
        					$value->on('stk.KodeItem','=','databarang.KodeItem')
        							->on('stk.RecordOwnerID','=','databarang.RecordOwnerID');
        			})
        			->where('databarang.RecordOwnerID','=',Auth::user()->RecordOwnerID)
        			->where(function ($query) use($keyword, $field) {
	                    for ($i = 0; $i < count($field); $i++){
	                        $query->orwhere($field[$i], 'like',  '%' . $keyword .'%');
	                    }      
	                });
	    if ($Status != "") {
	    	$dataobat->where('dataobat.Status', '=', $Status);
	    }
        $dataobat = $dataobat->paginate(4);

        $kelompokobat = KategoriObat::where('RecordOwnerID','=', Auth::user()->RecordOwnerID)->get();
        $lokasirak = Lokasi::where('RecordOwnerID','=', Auth::user()->RecordOwnerID)->get();

        $title = 'Delete Terapi Obat !';
        $text = "Are you sure you want to delete ?";
        confirmDelete($title, $text);
        return view("DataObat.DataObat",[
            'dataobat' => $dataobat, 
            'kelompokobat' => $kelompokobat,
            'lokasirak' => $lokasirak
        ]);
    }
    public function DataObat_Form($id = 0)
    {
    	$dataobat = DataObat::where('KodeItem','=',$id)->get();
        $kelompokobat = KategoriObat::where('RecordOwnerID','=', Auth::user()->RecordOwnerID)->get();
        $lokasirak = Lokasi::where('RecordOwnerID','=', Auth::user()->RecordOwnerID)->get();
        $satuan = Satuan::where('RecordOwnerID','=', Auth::user()->RecordOwnerID)->get();

        return view("DataObat.DataObat-input",[
            'dataobat' => $dataobat,
            'kelompokobat' => $kelompokobat,
            'lokasirak' => $lokasirak,
            'satuan' => $satuan
        ]);
    }

    public function store(Request $request)
    {
    	Log::debug($request->all());
        try {
            $this->validate($request, [
                'KodeItem'=>'required',
                'NamaItem'=>'required',
                'KodeSatuan'=>'required',
                'LokasiRakObat'=>'required',
                'HargaJual'=>'required',
            ]);

            $model = new DataObat;
            $model->KodeItem = $request->input('KodeItem');
			$model->NamaItem = $request->input('NamaItem');
			$model->KodeKelompok = $request->input('KodeKelompok');
			$model->KodeSatuan = $request->input('KodeSatuan');
			$model->LokasiRakObat = $request->input('LokasiRakObat');
			$model->MinQty = $request->input('MinQty');
			$model->HargaPokok = 0;
			$model->HargaJual = $request->input('HargaJual');
			$model->Active = $request->input('Active');
            $model->RecordOwnerID = Auth::user()->RecordOwnerID;

            $save = $model->save();

            if ($save) {
                alert()->success('Success','Data Obat Berhasil disimpan.');
                return redirect('dataobat');
                
            }else{
                throw new \Exception('Penambahan Data Gagal');
            }
        } catch (\Exception $e) {
            Log::debug($e->getMessage());

            alert()->error('Error',$e->getMessage());
            return redirect()->back();
        }
    }

    public function edit(Request $request)
    {
        Log::debug($request->all());
        try {
            $this->validate($request, [
                'KodeItem'=>'required',
                'NamaItem'=>'required',
                'KodeSatuan'=>'required',
                'LokasiRakObat'=>'required',
                'HargaJual'=>'required',
            ]);

            $model = DataObat::where('KodeItem','=',$request->input('KodeItem'));

            if ($model) {
            	// $model->Kode = $request->input('Kode');
             //    $model->Nama = $request->input('Nama');
                $update = DB::table('dataobat')
                			->where('KodeItem','=', $request->input('KodeItem'))
                            ->where('RecordOwnerID','=',Auth::user()->RecordOwnerID)
                			->update([
                				'NamaItem' 		=> $request->input('NamaItem'),
								'KodeKelompok' 	=> $request->input('KodeKelompok'),
								'KodeSatuan' 	=> $request->input('KodeSatuan'),
								'LokasiRakObat' => $request->input('LokasiRakObat'),
								'MinQty' 		=> $request->input('MinQty'),
								'HargaJual' 	=> $request->input('HargaJual'),
								'Active'		=> $request->input('Active')
                			]);

                if ($update) {
                    alert()->success('Success','Data Data Obat berhasil disimpan.');
                    return redirect('dataobat');
                }else{
                    throw new \Exception('Edit Data Obat Gagal');
                }
            } else{
                throw new \Exception('Data Obat not found.');
            }
        } catch (Exception $e) {
            Log::debug($e->getMessage());

            alert()->error('Error',$e->getMessage());
            return redirect()->back();
        }
    }

}
