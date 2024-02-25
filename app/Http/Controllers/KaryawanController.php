<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use DB;
use Log;
use Illuminate\Support\Facades\Validator;
use RealRashid\SweetAlert\Facades\Alert;

use App\Models\Karyawan;

class KaryawanController extends Controller
{
    public function KaryawanView(Request $request)
    {
    	$field = ['NIK','NamaKaryawan','Alamat'];
        $keyword = $request->input('keyword');

        $karyawan = Karyawan::Where(function ($query) use($keyword, $field) {
                    for ($i = 0; $i < count($field); $i++){
                        $query->orwhere($field[$i], 'like',  '%' . $keyword .'%');
                    }      
                })->where('RecordOwnerID','=',Auth::user()->RecordOwnerID);

        if ($request->input('status') == "1") {
            $karyawan = $karyawan->where('TanggalResign',null);
        }
        elseif ($request->input('status') == "0") {
            $karyawan = $karyawan->where('TanggalResign','!=',null);   
        }

        $karyawan = $karyawan->paginate(4);

        $title = 'Delete Karyawan !';
        $text = "Are you sure you want to delete ?";
        confirmDelete($title, $text);
        return view("master.Karyawan.Karyawan",[
            'karyawan' => $karyawan, 
        ]);
    }

    public function Karyawan_Form($id = 0)
    {
        $karyawan = Karyawan::where('NIK','=',$id)->get();
        
        return view("master.Karyawan.Karyawan-input",[
            'karyawan' => $karyawan
        ]);
    }

    public function store(Request $request)
    {
        Log::debug($request->all());
        try {
            $this->validate($request, [
                'NIK'=>'required',
                'NamaKaryawan'=>'required',
                'JenisKelamin'=>'required',
                'TempatLahir'=>'required',
                'TanggalLahir'=>'required',
                'NoTlp'=>'required',
                'TanggalBergabung'=>'required',
            ]);

            $model = new Karyawan;
            $model->NIK = $request->input('NIK');
            $model->NamaKaryawan = $request->input('NamaKaryawan');
            $model->JenisKelamin = $request->input('JenisKelamin');
            $model->TempatLahir = $request->input('TempatLahir');
            $model->TanggalLahir = $request->input('TanggalLahir');
            $model->NoTlp = $request->input('NoTlp');
            $model->Alamat = $request->input('Alamat');
            $model->TanggalBergabung = $request->input('TanggalBergabung');
            $model->TanggalResign = $request->input('TanggalResign');
            $model->RecordOwnerID = Auth::user()->RecordOwnerID;

            $save = $model->save();

            if ($save) {
                alert()->success('Success','Data Karyawan Berahasil disimpan.');
                return redirect('karyawan');
                
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
                'NIK'=>'required',
                'NamaKaryawan'=>'required',
                'JenisKelamin'=>'required',
                'TempatLahir'=>'required',
                'TanggalLahir'=>'required',
                'NoTlp'=>'required',
                'TanggalBergabung'=>'required',
            ]);

            $model = Karyawan::where('NIK','=',$request->input('NIK'));

            if ($model) {
                // $model->Kode = $request->input('Kode');
             //    $model->Nama = $request->input('Nama');
                $update = DB::table('karyawan')
                            ->where('NIK','=', $request->input('NIK'))
                            ->where('RecordOwnerID','=',Auth::user()->RecordOwnerID)
                            ->update([
                                'NamaKaryawan' =>$request->input('NamaKaryawan'),
                                'JenisKelamin' =>$request->input('JenisKelamin'),
                                'TempatLahir' =>$request->input('TempatLahir'),
                                'TanggalLahir' =>$request->input('TanggalLahir'),
                                'NoTlp' =>$request->input('NoTlp'),
                                'Alamat' =>$request->input('Alamat'),
                                'TanggalBergabung' =>$request->input('TanggalBergabung'),
                                'TanggalResign' =>$request->input('TanggalResign'),
                            ]);

                if ($update) {
                    alert()->success('Success','Data Karyawan berhasil disimpan.');
                    return redirect('karyawan');
                }else{
                    throw new \Exception('Edit Karyawan Gagal');
                }
            } else{
                throw new \Exception('Karyawan not found.');
            }
        } catch (Exception $e) {
            Log::debug($e->getMessage());

            alert()->error('Error',$e->getMessage());
            return redirect()->back();
        }
    }
}
