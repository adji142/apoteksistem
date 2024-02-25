<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use DB;
use Log;

use App\Models\Shift;

class ShiftController extends Controller
{
    public function ShiftView(Request $request)
    {
    	$field = ['Nama'];
        $keyword = $request->input('keyword');

        $shift = Shift::Where(function ($query) use($keyword, $field) {
                    for ($i = 0; $i < count($field); $i++){
                        $query->orwhere($field[$i], 'like',  '%' . $keyword .'%');
                    }      
                })->where('RecordOwnerID','=',Auth::user()->RecordOwnerID);

        $shift = $shift->paginate(4);

        $title = 'Delete Shift !';
        $text = "Are you sure you want to delete ?";
        confirmDelete($title, $text);
        return view("master.Shift.Shift",[
            'shift' => $shift, 
        ]);
    }

    public function Shift_Form($id = 0)
    {
    	$shift = Shift::where('Kode','=',$id)->get();
        
        return view("master.Shift.Shift-input",[
            'shift' => $shift
        ]);
    }

    public function store(Request $request)
    {
    	Log::debug($request->all());
        try {
            $this->validate($request, [
                'Nama'=>'required',
                'Kode'=>'required',
                'MulaiKerja'=>'required',
                'SelesaiKerja'=>'required',
            ]);

            // Carbon::parse($request->input('check_in'))->format('Y-m-d');
            $model = new Shift;
            $model->Kode = $request->input('Kode');
            $model->Nama = $request->input('Nama');
            $model->MulaiKerja = Carbon::parse($request->input('MulaiKerja'))->format('H:i:s');
            $model->SelesaiKerja = Carbon::parse($request->input('SelesaiKerja'))->format('H:i:s');
            $model->RecordOwnerID = Auth::user()->RecordOwnerID;

            $save = $model->save();

            if ($save) {
                alert()->success('Success','Data Shift disimpan.');
                return redirect('shift');
                
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
                'MulaiKerja'=>'required',
                'SelesaiKerja'=>'required',
            ]);

            $model = Shift::where('Kode','=',$request->input('Kode'));

            if ($model) {
            	// $model->Kode = $request->input('Kode');
             //    $model->Nama = $request->input('Nama');
                $update = DB::table('shift')
                			->where('Kode','=', $request->input('Kode'))
                			->update([
                				'Nama'=>$request->input('Nama'),
                				'MulaiKerja' => Carbon::parse($request->input('MulaiKerja'))->format('H:i:s'),
                				'SelesaiKerja' => Carbon::parse($request->input('SelesaiKerja'))->format('H:i:s'),
                			])->where('RecordOwnerID','=',Auth::user()->RecordOwnerID);

                if ($update) {
                    alert()->success('Success','Data Shift berhasil disimpan.');
                    return redirect('shift');
                }else{
                    throw new \Exception('Edit Shift Gagal');
                }
            } else{
                throw new \Exception('Shift not found.');
            }
        } catch (Exception $e) {
            Log::debug($e->getMessage());

            alert()->error('Error',$e->getMessage());
            return redirect()->back();
        }
    }

    public function shift_delete(Request $request)
    {
        $user = DB::table('shift')
                    ->where('Kode','=', $request->id)
                    ->where('RecordOwnerID','=',Auth::user()->RecordOwnerID)
                    ->delete();

        if ($user) {
        	alert()->success('Success','Delete Shift Obat berhasil.');
        }
        else{
        	alert()->error('Error','Delete Shift Obat Gagal.');
        }
        return redirect('shift');
    }
}
