<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use DB;
use Log;

use App\Models\TerapiObat;

class TerapiObatController extends Controller
{
    public function TerapiObatView(Request $request)
    {
    	$field = ['Nama'];
        $keyword = $request->input('keyword');

        $terapi = TerapiObat::Where(function ($query) use($keyword, $field) {
                    for ($i = 0; $i < count($field); $i++){
                        $query->orwhere($field[$i], 'like',  '%' . $keyword .'%');
                    }      
                })->where('RecordOwnerID','=',Auth::user()->RecordOwnerID);

        $terapi = $terapi->paginate(4);

        $title = 'Delete Terapi Obat !';
        $text = "Are you sure you want to delete ?";
        confirmDelete($title, $text);
        return view("master.TerapiObat.TerapiObat",[
            'terapi' => $terapi, 
        ]);
    }

    public function TerapiObat_Form($id = null)
    {
    	$terapi = TerapiObat::find($id);
        
        return view("master.TerapiObat.TerapiObat-input",[
            'terapi' => $terapi
        ]);
    }

    public function store(Request $request)
    {
    	Log::debug($request->all());
        try {
            $this->validate($request, [
                'Nama'=>'required',
            ]);

            $model = new TerapiObat;
            $model->Nama = $request->input('Nama');
            $model->RecordOwnerID = Auth::user()->RecordOwnerID;

            $save = $model->save();

            if ($save) {
                alert()->success('Success','Data Terapi Obat disimpan.');
                return redirect('terapiobat');
                
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

            $model = TerapiObat::find($request->input('id'));

            if ($model) {
                $model->Nama = $request->input('Nama');
                $update = $model->update();

                if ($update) {
                    alert()->success('Success','Data Terapi Obat berhasil disimpan.');
                    return redirect('terapiobat');
                }else{
                    throw new \Exception('Edit Terapi Obat Gagal');
                }
            } else{
                throw new \Exception('Terapi Obat not found.');
            }
        } catch (Exception $e) {
            Log::debug($e->getMessage());

            alert()->error('Error',$e->getMessage());
            return redirect()->back();
        }
    }

    public function terapiobat_delete(Request $request)
    {
    	$user = TerapiObat::find($request->id);
        $user->delete();

        alert()->success('Success','Delete Terapi Obat berhasil.');
        return redirect('terapiobat');
    }
}
