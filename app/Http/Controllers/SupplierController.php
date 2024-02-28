<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use DB;
use Log;

use App\Models\Supplier;

class SupplierController extends Controller
{
    public function SupplierView(Request $request)
    {
    	$field = ['NamaSupplier','Alamat','NoTlp'];
        $keyword = $request->input('keyword');

        $supplier = Supplier::Where(function ($query) use($keyword, $field) {
                    for ($i = 0; $i < count($field); $i++){
                        $query->orwhere($field[$i], 'like',  '%' . $keyword .'%');
                    }      
                })->where('RecordOwnerID','=',Auth::user()->RecordOwnerID)
        		->where('Active','=',1);

        $supplier = $supplier->paginate(4);

        $title = 'Delete Supllier !';
        $text = "Are you sure you want to delete ?";
        confirmDelete($title, $text);
        return view("supplier.Supplier",[
            'supplier' => $supplier, 
        ]);
    }

    public function Supplier_Form($id = 0)
    {
    	$supplier = Supplier::find($id);
        
        return view("supplier.supplier-input",[
            'supplier' => $supplier
        ]);
    }

    public function store(Request $request)
    {
    	Log::debug($request->all());
        try {
            $this->validate($request, [
                'NamaSupplier'=>'required',
                'Alamat'=>'required',
                'Kota'=>'required',
                'NoTlp'=>'required',
            ]);

            // Carbon::parse($request->input('check_in'))->format('Y-m-d');
            $model = new Supplier;
            $model->NamaSupplier = $request->input('NamaSupplier');
			$model->Alamat = $request->input('Alamat');
			$model->Kota = $request->input('Kota');
			$model->NoTlp = $request->input('NoTlp');
			$model->Active = 1;
            $model->RecordOwnerID = Auth::user()->RecordOwnerID;

            $save = $model->save();

            if ($save) {
                alert()->success('Success','Data Supplier disimpan.');
                return redirect('supplier');
                
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
                'NamaSupplier'=>'required',
                'Alamat'=>'required',
                'Kota'=>'required',
                'NoTlp'=>'required',
            ]);

            $model = Supplier::find($request->input('id'));

            if ($model) {
                $model->NamaSupplier = $request->input('NamaSupplier');
				$model->Alamat = $request->input('Alamat');
				$model->Kota = $request->input('Kota');
				$model->NoTlp = $request->input('NoTlp');
                $update = $model->update();

                if ($update) {
                    alert()->success('Success','Data Supplier berhasil disimpan.');
                    return redirect('supplier');
                }else{
                    throw new \Exception('Edit Supplier Gagal');
                }
            } else{
                throw new \Exception('Supplier not found.');
            }
        } catch (Exception $e) {
            Log::debug($e->getMessage());

            alert()->error('Error',$e->getMessage());
            return redirect()->back();
        }
    }

    public function supplier_delete(Request $request) {
        $user = Supplier::find($request->id);

        if ($user) {
        	$user->Active = 0;
        	$save = $user->update();

        	if ($save) {
                alert()->success('Success','Delete Supplier berhasil.');
                // return redirect('supplier');
            }else{
                throw new \Exception('Edit Supplier Gagal');
            }
        }

        
        return redirect('supplier');
    }
}
