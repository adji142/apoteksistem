<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use DB;
use Log;

use App\Models\AkunKas;
use App\Models\TransaksiKas;

class TransaksiKasController extends Controller
{
    public function TransaksiKasView(Request $request)
    {
    	$field = ['transaksikas.NoTransaksi','transaksikas.KodeAkun','akunkas.NamaAkun','transaksikas.Keterangan'];
        $keyword = $request->input('keyword');

        $sql = "transaksikas.NoTransaksi, DATE(transaksikas.TglTransaksi) Tanggal, akunkas.NamaAkun, CASE WHEN transaksikas.Transaksi = 1 THEN transaksikas.Total ELSE 0 END Debit, CASE WHEN transaksikas.Transaksi = 2 THEN transaksikas.Total ELSE 0 END Kredit, transaksikas.Keterangan ";
        $transaksikas = TransaksiKas::selectRaw($sql)
        			->leftJoin('akunkas', function ($value){
        				$value->on('akunkas.id','=','transaksikas.KodeAkun')
        						->on('akunkas.RecordOwnerID','=','transaksikas.RecordOwnerID');
        			})
        			->where('transaksikas.RecordOwnerID','=',Auth::user()->RecordOwnerID)
        			->where(function ($query) use($keyword,$field)
        			{
        				for ($i = 0; $i < count($field); $i++){
	                        $query->orwhere($field[$i], 'like',  '%' . $keyword .'%');
	                    }     
        			});

        $transaksikas = $transaksikas->paginate(4);

        $title = 'Delete Transaksi Kas !';
        $text = "Are you sure you want to delete ?";
        confirmDelete($title, $text);
        return view("transaksi.kas.transaksikas",[
            'transaksikas' => $transaksikas, 
        ]);
    }

    public function TransaksiKas_Form($id = null)
    {
    	$transaksikas = TransaksiKas::where('NoTransaksi','=',$id)->get();
    	$akunkas = AkunKas::where('RecordOwnerID','=',Auth::user()->RecordOwnerID)->get();
        
        return view("transaksi.kas.transaksikas-input",[
            'transaksikas' => $transaksikas,
            'akunkas' => $akunkas
        ]);
    }

    public function store(Request $request)
    {
    	Log::debug($request->all());
        try {
            $this->validate($request, [
                'TglTransaksi'=>'required',
                'KodeAkun'=>'required',
                'Total'=>'required'
            ]);

            $prefix = 'KAS'.substr(date('Ymd'),2,8);
            $lastNoTrx = TransaksiKas::where('RecordOwnerID','=',Auth::user()->RecordOwnerID)
                            ->where(DB::raw('LEFT(NoTransaksi,8)'),'=',$prefix)->count()+1;
            $NoTransaksi = $prefix.str_pad($lastNoTrx, 4, '0', STR_PAD_LEFT);

            $model = new TransaksiKas;
            $model->NoTransaksi = $NoTransaksi;
			$model->TglTransaksi = $request->input('TglTransaksi');
			$model->KodeAkun = $request->input('KodeAkun');
			$model->Keterangan = $request->input('Keterangan');
			$model->Transaksi = $request->input('Transaksi');
			$model->Total = $request->input('Total');
			$model->StatusTRX = 'O';
            $model->RecordOwnerID = Auth::user()->RecordOwnerID;

            $save = $model->save();

            if ($save) {
                alert()->success('Success','Transaksi Kas disimpan.');
                return redirect('transaksikas');
                
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
                'TglTransaksi'=>'required',
                'KodeAkun'=>'required',
                'Total'=>'required'
            ]);

            $model = TransaksiKas::where('NoTransaksi','=',$request->input('NoTransaksi'));

            if ($model) {
            	// $model->Kode = $request->input('Kode');
             //    $model->Nama = $request->input('Nama');
                $update = DB::table('transaksikas')
                			->where('NoTransaksi','=', $request->input('NoTransaksi'))
                            ->where('RecordOwnerID','=',Auth::user()->RecordOwnerID)
                			->update([
                				'TglTransaksi'=>$request->input('TglTransaksi'),
                				'KodeAkun'=>$request->input('KodeAkun'),
                				'Keterangan'=>$request->input('Keterangan'),
                				'Transaksi'=>$request->input('Transaksi'),
                				'Total'=>$request->input('Total')
                			]);

                if ($update) {
                    alert()->success('Success','Transaksi Kas berhasil disimpan.');
                    return redirect('transaksikas');
                }else{
                    throw new \Exception('Edit Transaksi Gagal');
                }
            } else{
                throw new \Exception('Transaksi not found.');
            }
        } catch (\Exception $e) {
            Log::debug($e->getMessage());

            alert()->error('Error',$e->getMessage());
            return redirect()->back();
        }
    }

    public function TransaksiKas_delete(Request $request)
    {
    	Log::debug($request->all());
        try {

            $model = TransaksiKas::where('NoTransaksi','=',$request->input('NoTransaksi'));

            if ($model) {
            	// $model->Kode = $request->input('Kode');
             //    $model->Nama = $request->input('Nama');
                $update = DB::table('transaksikas')
                			->where('NoTransaksi','=', $request->input('NoTransaksi'))
                            ->where('RecordOwnerID','=',Auth::user()->RecordOwnerID)
                			->update([
                				'StatusTRX'=>'N'
                			]);

                if ($update) {
                    alert()->success('Success','Transaksi Kas berhasil Dihapus.');
                    return redirect('transaksikas');
                }else{
                    throw new \Exception('Hapus Transaksi Gagal');
                }
            } else{
                throw new \Exception('Transaksi not found.');
            }
        } catch (\Exception $e) {
            Log::debug($e->getMessage());

            alert()->error('Error',$e->getMessage());
            return redirect()->back();
        }
        return redirect('transaksikas');
    }

    public function ReportKas(Request $request)
    {
        $data = array('success'=>true, 'message'=>'', 'data'=>array());

        $query = DB::select('CALL rsp_laporan_kartu_kas(?,?,?)', array($request->input('TglAwal'), $request->input('TglAkhir'), Auth::user()->RecordOwnerID ));

        $data['success'] = true;
        $data['data'] = $query;

        return response()->json($data);
    }
}
