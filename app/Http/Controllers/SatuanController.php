<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use DB;
use Log;

use App\Models\Satuan;

class SatuanController extends Controller
{
    public function SatuanView(Request $request)
    {
    	$field = ['Nama'];
        $keyword = $request->input('keyword');

        $satuan = Satuan::Where(function ($query) use($keyword, $field) {
                    for ($i = 0; $i < count($field); $i++){
                        $query->orwhere($field[$i], 'like',  '%' . $keyword .'%');
                    }      
                });

        $satuan = $satuan->paginate(4);

        $title = 'Delete Terapi Obat !';
        $text = "Are you sure you want to delete ?";
        confirmDelete($title, $text);
        return view("master.Satuan.Satuan",[
            'satuan' => $satuan, 
        ]);
    }

    public function Satuan_Form($id = 0)
    {
    	$satuan = Satuan::where('Kode','=',$id)->get();
        
        return view("master.Satuan.Satuan-input",[
            'satuan' => $satuan
        ]);
    }

    public function store(Request $request)
    {
    	Log::debug($request->all());
        try {
            $this->validate($request, [
                'Nama'=>'required',
            ]);

            $model = new Satuan;
            $model->Kode = $request->input('Kode');
            $model->Nama = $request->input('Nama');
            $model->RecordOwnerID = Auth::user()->RecordOwnerID;

            $save = $model->save();

            if ($save) {
                alert()->success('Success','Data Satuan disimpan.');
                return redirect('satuan');
                
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
            ]);

            $model = Satuan::where('Kode','=',$request->input('Kode'));

            if ($model) {
            	// $model->Kode = $request->input('Kode');
             //    $model->Nama = $request->input('Nama');
                $update = DB::table('satuan')
                			->where('Kode','=', $request->input('Kode'))
                			->update(['Nama'=>$request->input('Nama')]);

                if ($update) {
                    alert()->success('Success','Data Satuan berhasil disimpan.');
                    return redirect('satuan');
                }else{
                    throw new \Exception('Edit Satuan Gagal');
                }
            } else{
                throw new \Exception('Satuan not found.');
            }
        } catch (Exception $e) {
            Log::debug($e->getMessage());

            alert()->error('Error',$e->getMessage());
            return redirect()->back();
        }
    }

    public function satuan_delete(Request $request)
    {
        $user = DB::table('satuan')->where('Kode','=', $request->id)->delete();

        if ($user) {
        	alert()->success('Success','Delete Satuan Obat berhasil.');
        }
        else{
        	alert()->error('Error','Delete Satuan Obat Gagal.');
        }
        return redirect('satuan');
    }


}
