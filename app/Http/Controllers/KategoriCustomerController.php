<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use DB;
use Log;

// Models
use App\Models\KategoriCustomer;

class KategoriCustomerController extends Controller
{
    public function KategoriCustomer(Request $request)
    {
        $field = ['Nama'];
        $keyword = $request->input('keyword');

        $kategori = KategoriCustomer::Where(function ($query) use($keyword, $field) {
                    for ($i = 0; $i < count($field); $i++){
                        $query->orwhere($field[$i], 'like',  '%' . $keyword .'%');
                    }      
                })->where('RecordOwnerID','=',Auth::user()->RecordOwnerID);

        $kategori = $kategori->paginate(4);

        $title = 'Delete User !';
        $text = "Are you sure you want to delete ?";
        confirmDelete($title, $text);
        return view("master.kategoricustomer",[
            'kategori' => $kategori, 
        ]);
    }

    public function KategoriCustomer_form($id = null) {
        $kategori = KategoriCustomer::find($id);
        
        return view("master.kategoricustomer-input",[
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

            $model = new KategoriCustomer;
            $model->Nama = $request->input('Nama');
            $model->RecordOwnerID = Auth::user()->RecordOwnerID;

            $save = $model->save();

            if ($save) {
                alert()->success('Success','Data Kelompok berhasil disimpan.');
                return redirect('kategoricustomer');
                
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

            $model = KategoriCustomer::find($request->input('id'));

            if ($model) {
                $model->Nama = $request->input('Nama');
                $update = $model->update();

                if ($update) {
                    alert()->success('Success','Data Kategori Customer berhasil disimpan.');
                    return redirect('kategoricustomer');
                }else{
                    throw new \Exception('Edit Kategori Customer Gagal');
                }
            } else{
                throw new \Exception('Kategori Customer not found.');
            }
        } catch (Exception $e) {
            Log::debug($e->getMessage());

            alert()->error('Error',$e->getMessage());
            return redirect()->back();
        }
    }
    public function kategoricustomer_delete(Request $request) {
        $user = KategoriCustomer::find($request->id);
        $user->delete();

        alert()->success('Success','Delete Kategori Customer berhasil.');
        return redirect('kategoricustomer');
    }
}
