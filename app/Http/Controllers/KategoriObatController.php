<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use DB;
use Log;

// Models
use App\Models\KategoriObat;

class KategoriObatController extends Controller
{
    public function i_KategoriObat(Request $request)
    {
        $field = ['Nama'];
        $keyword = $request->input('keyword');

        $kategori = KategoriObat::Where(function ($query) use($keyword, $field) {
                    for ($i = 0; $i < count($field); $i++){
                        $query->orwhere($field[$i], 'like',  '%' . $keyword .'%');
                    }      
                })->where('RecordOwnerID','=',Auth::user()->RecordOwnerID);

        $kategori = $kategori->paginate(4);

        $title = 'Delete Kategori Obat !';
        $text = "Are you sure you want to delete ?";
        confirmDelete($title, $text);
        return view("master.KategoriObat.kategoriobat",[
            'kategori' => $kategori, 
        ]);
    }

    public function KategoriObat_form($id = null) {
        $kategori = KategoriObat::find($id);
        
        return view("master.KategoriObat.kategoriobat-input",[
            'kategori' => $kategori
        ]);
    }

    public function store(Request $request)
    {
        Log::debug($request->all());
        try {
            $this->validate($request, [
                'Nama'=>'required',
            ]);

            $model = new KategoriObat;
            $model->Nama = $request->input('Nama');
            $model->RecordOwnerID = Auth::user()->RecordOwnerID;

            $save = $model->save();

            if ($save) {
                alert()->success('Success','Data Kelompok berhasil disimpan.');
                return redirect('kategoriobat');
                
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

            $model = KategoriObat::find($request->input('id'));

            if ($model) {
                $model->Nama = $request->input('Nama');
                $update = $model->update();

                if ($update) {
                    alert()->success('Success','Data Kategori Obat berhasil disimpan.');
                    return redirect('kategoriobat');
                }else{
                    throw new \Exception('Edit Kategori Obat Gagal');
                }
            } else{
                throw new \Exception('Kategori Obat not found.');
            }
        } catch (Exception $e) {
            
        }
    }
    public function kategoriobat_delete(Request $request) {
        $user = KategoriObat::find($request->id);
        $user->delete();

        alert()->success('Success','Delete Kategori Obat berhasil.');
        return redirect('kategoriobat');
    }
}
