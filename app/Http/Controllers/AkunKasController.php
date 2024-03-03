<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use DB;
use Log;

use App\Models\AkunKas;

class AkunKasController extends Controller
{
    public function AkunKasView(Request $request)
    {
    	$field = ['NamaAkun','Keterangan'];
        $keyword = $request->input('keyword');

        $akunkas = AkunKas::Where(function ($query) use($keyword, $field) {
                    for ($i = 0; $i < count($field); $i++){
                        $query->orwhere($field[$i], 'like',  '%' . $keyword .'%');
                    }      
                })->where('RecordOwnerID','=',Auth::user()->RecordOwnerID);

        $akunkas = $akunkas->paginate(4);

        $title = 'Delete Akun Kas !';
        $text = "Are you sure you want to delete ?";
        confirmDelete($title, $text);
        return view("master.AkunKas.AkunKas",[
            'akunkas' => $akunkas, 
        ]);
    }

    public function AkunKas_Form($id = null)
    {
    	$akunkas = AkunKas::find($id);
        
        return view("master.AkunKas.AkunKas-input",[
            'akunkas' => $akunkas
        ]);
    }

    public function store(Request $request)
    {
    	Log::debug($request->all());
        try {
            $this->validate($request, [
                'NamaAkun'=>'required'
            ]);

            $model = new AkunKas;
            $model->NamaAkun = $request->input('NamaAkun');
            $model->Keterangan = $request->input('Keterangan');
            $model->SaldoAkun = 0;
            $model->RecordOwnerID = Auth::user()->RecordOwnerID;

            $save = $model->save();

            if ($save) {
                alert()->success('Success','Data Akun Kas disimpan.');
                return redirect('akunkas');
                
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
                'NamaAkun'=>'required',
            ]);

            $model = AkunKas::find($request->input('id'));

            if ($model) {
                $model->NamaAkun = $request->input('NamaAkun');
                $model->Keterangan = $request->input('Keterangan');
                $update = $model->update();

                if ($update) {
                    alert()->success('Success','Data Akun Kas berhasil disimpan.');
                    return redirect('akunkas');
                }else{
                    throw new \Exception('Edit Terapi Obat Gagal');
                }
            } else{
                throw new \Exception('Akun Kas not found.');
            }
        } catch (\Exception $e) {
            Log::debug($e->getMessage());

            alert()->error('Error',$e->getMessage());
            return redirect()->back();
        }
    }

    public function akunkas_delete(Request $request)
    {
    	$user = AkunKas::find($request->id);
        $user->delete();

        alert()->success('Success','Akun Kas Obat berhasil.');
        return redirect('akunkas');
    }
}
