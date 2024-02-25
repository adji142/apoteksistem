<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use DB;
use Log;

use App\Models\Lokasi;

class LokasiController extends Controller
{
    public function LokasiView(Request $request)
    {
    	$field = ['Nama'];
        $keyword = $request->input('keyword');

        $lokasi = Lokasi::Where(function ($query) use($keyword, $field) {
                    for ($i = 0; $i < count($field); $i++){
                        $query->orwhere($field[$i], 'like',  '%' . $keyword .'%');
                    }      
                })->where('RecordOwnerID','=',Auth::user()->RecordOwnerID);

        $lokasi = $lokasi->paginate(4);

        $title = 'Delete Terapi Obat !';
        $text = "Are you sure you want to delete ?";
        confirmDelete($title, $text);
        return view("master.Lokasi.Lokasi",[
            'lokasi' => $lokasi, 
        ]);
    }

    public function Lokasi_Form($id = 0)
    {
    	$lokasi = Lokasi::where('Kode','=',$id)->get();
        
        return view("master.Lokasi.Lokasi-input",[
            'lokasi' => $lokasi
        ]);
    }

    public function store(Request $request)
    {
    	Log::debug($request->all());
        try {
            $this->validate($request, [
                'Nama'=>'required',
                'Kode'=>'required',
            ]);

            $model = new Lokasi;
            $model->Kode = $request->input('Kode');
            $model->Nama = $request->input('Nama');
            $model->RecordOwnerID = Auth::user()->RecordOwnerID;

            $save = $model->save();

            if ($save) {
                alert()->success('Success','Data Lokasi disimpan.');
                return redirect('lokasi');
                
            }else{
                throw new \Exception('Penambahan Data Gagal');
            }
        } catch (Exception $e) {
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
                'Nama'=>'required',
                'Kode'=>'required',
            ]);

            $model = Lokasi::where('Kode','=',$request->input('Kode'));

            if ($model) {
            	// $model->Kode = $request->input('Kode');
             //    $model->Nama = $request->input('Nama');
                $update = DB::table('lokasi')
                			->where('Kode','=', $request->input('Kode'))
                            ->where('RecordOwnerID','=',Auth::user()->RecordOwnerID)
                			->update(['Nama'=>$request->input('Nama')]);

                if ($update) {
                    alert()->success('Success','Data Lokasi berhasil disimpan.');
                    return redirect('lokasi');
                }else{
                    throw new \Exception('Edit Lokasi Gagal');
                }
            } else{
                throw new \Exception('Lokasi not found.');
            }
        } catch (Exception $e) {
            Log::debug($e->getMessage());

            alert()->error('Error',$e->getMessage());
            return redirect()->back();
        }
    }

    public function lokasi_delete(Request $request)
    {
        $user = DB::table('lokasi')
                    ->where('Kode','=', $request->id)
                    ->where('RecordOwnerID','=',Auth::user()->RecordOwnerID)
                    ->delete();

        if ($user) {
        	alert()->success('Success','Delete Lokasi Obat berhasil.');
        }
        else{
        	alert()->error('Error','Delete Lokasi Obat Gagal.');
        }
        return redirect('lokasi');
    }
}
