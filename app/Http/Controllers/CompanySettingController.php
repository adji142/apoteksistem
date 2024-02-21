<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use DB;
use Log;

// Models
use App\Models\CompanySetting;

class CompanySettingController extends Controller
{
    public function companysetting()
    {
    	$setting = CompanySetting::where('KodePartner','=',Auth::user()->RecordOwnerID)->get();
        return view("master.setting",[
            'data' => $setting, 
        ]);
    }

    public function setting_store(Request $request)
    {
    	Log::debug($request->all());
    	DB::beginTransaction();

    	try {
    		$this->validate($request, [
                'NamaPartner'=>'required',
                'Alamat'=>'required',
                'NoTlp'=>'required',
                'SIPA'=>'required',
                'SIA'=>'required',
            ]);

            $save = DB::table('companysetting')
            			->where('KodePartner','=',Auth::user()->RecordOwnerID)
            			->update(
            				[
            					'NamaPartner' => $request->input('NamaPartner'),
            					'Alamat' => $request->input('Alamat'),
            					'NoTlp' => $request->input('NoTlp'),
            					'SIA' => $request->input('SIA'),
            					'SIPA' => $request->input('SIPA'),
            					'PrinterType' => $request->input('PrinterType'),
            					'PrinterDeviceName' => $request->input('PrinterDeviceName'),
                                'PerhitunganHargaPokok' => $request->input('PerhitunganHargaPokok'),
            				]
            			);
            if ($save) {
                DB::commit();

                alert()->success('Success','Data berhasil disimpan.');
                
            }else{
                throw new \Exception('Gagal simpan data');
            }
    	} catch (Exception $e) {
    		DB::rollback();
            Log::debug($e->getMessage() . ' ' . $e->getLine());

            alert()->error('Error',$e->getMessage());
    	}
    	return redirect()->route('setting');
    }
}
