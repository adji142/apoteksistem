<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use DB;
use Log;

// Models
use App\Models\MetodePembayaran;

class MetodePembayaranController extends Controller
{
    public function MetodePembayaranView(Request $request)
    {
    	$field = ['NamaMetodePembayaran','VendorPaymentGateway','MerchantID'];
        $keyword = $request->input('keyword');

        $metodepembayaran = MetodePembayaran::Where(function ($query) use($keyword, $field) {
                    for ($i = 0; $i < count($field); $i++){
                        $query->orwhere($field[$i], 'like',  '%' . $keyword .'%');
                    }      
                })->where('RecordOwnerID','=',Auth::user()->RecordOwnerID);

        $metodepembayaran = $metodepembayaran->paginate(4);

        $title = 'Delete Metode Pembayaran !';
        $text = "Are you sure you want to delete ?";
        confirmDelete($title, $text);
        return view("master.MetodePembayaran.MetodePembayaran",[
            'metodepembayaran' => $metodepembayaran, 
        ]);
    }

    public function MetodePembayaran_Form($id = null)
    {
    	$metodepembayaran = MetodePembayaran::find($id);
        
        return view("master.MetodePembayaran.MetodePembayaran-input",[
            'metodepembayaran' => $metodepembayaran
        ]);
    }

    public function store(Request $request)
    {
    	Log::debug($request->all());
        try {
            $this->validate($request, [
                'NamaMetodePembayaran'=>'required',
                'JenisVerifikasi' => 'required'
            ]);


            $model = new MetodePembayaran;
            $model->NamaMetodePembayaran = $request->input('NamaMetodePembayaran');
			$model->JenisVerifikasi = $request->input('JenisVerifikasi');
			$model->VendorPaymentGateway = $request->input('VendorPaymentGateway');
			$model->MerchantID = $request->input('MerchantID');
			$model->MerchantKey = $request->input('MerchantKey');
			$model->ServerKey = $request->input('ServerKey');
            $model->AcctNumber = $request->input('AcctNumber');
            $model->AcctName = $request->input('AcctName');
			$model->Active = $request->input('Active');

            $model->RecordOwnerID = Auth::user()->RecordOwnerID;

            $save = $model->save();

            if ($save) {
                alert()->success('Success','Data Metode Pembayaran disimpan.');
                return redirect('metodepembayaran');
                
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
                'NamaMetodePembayaran'=>'required',
                'JenisVerifikasi' => 'required'
            ]);

            $model = MetodePembayaran::find($request->input('id'));

            if ($model) {
                $model->Nama = $request->input('Nama');
                $model->NamaMetodePembayaran = $request->input('NamaMetodePembayaran');
				$model->JenisVerifikasi = $request->input('JenisVerifikasi');
				$model->VendorPaymentGateway = $request->input('VendorPaymentGateway');
				$model->MerchantID = $request->input('MerchantID');
				$model->MerchantKey = $request->input('MerchantKey');
				$model->ServerKey = $request->input('ServerKey');
                $model->AcctNumber = $request->input('AcctNumber');
                $model->AcctName = $request->input('AcctName');
				$model->Active = $request->input('Active');

                $update = $model->update();

                if ($update) {
                    alert()->success('Success','Data Metode Pembayaran berhasil disimpan.');
                    return redirect('metodepembayaran');
                }else{
                    throw new \Exception('Edit Metode Pembayaran');
                }
            } else{
                throw new \Exception('Metode Pembayaran not found.');
            }
        } catch (Exception $e) {
            Log::debug($e->getMessage());

            alert()->error('Error',$e->getMessage());
            return redirect()->back();
        }
    }
}
