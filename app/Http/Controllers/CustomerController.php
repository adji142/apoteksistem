<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use DB;
use Log;

use App\Models\Customer;
use App\Models\KategoriCustomer;

class CustomerController extends Controller
{
    public function CustomerView(Request $request)
    {
    	$field = ['NamaCustomer','Email','NoTlp'];
        $keyword = $request->input('keyword');

        $customer = Customer::Where(function ($query) use($keyword, $field) {
                    for ($i = 0; $i < count($field); $i++){
                        $query->orwhere($field[$i], 'like',  '%' . $keyword .'%');
                    }      
                })->where('RecordOwnerID','=',Auth::user()->RecordOwnerID)
        		->where('Active','=',1);

        $customer = $customer->paginate(4);

        $title = 'Delete Supllier !';
        $text = "Are you sure you want to delete ?";
        confirmDelete($title, $text);
        return view("customer.customer",[
            'customer' => $customer, 
        ]);
    }

    public function Customer_Form($id = 0)
    {
    	$customer = Customer::find($id);
    	$kelompokcustomer = KategoriCustomer::where('RecordOwnerID','=',Auth::user()->RecordOwnerID)->get();
        
        return view("customer.customer-input",[
            'customer' => $customer,
            'kelompokcustomer' => $kelompokcustomer
        ]);
    }

    public function store(Request $request)
    {
    	Log::debug($request->all());
        try {
            $this->validate($request, [
                'NamaCustomer'=>'required',
                'NoTlp'=>'required',
                'KategoriCustomer'=>'required',
                'Alamat'=>'required',
                'Kota' => 'required'
            ]);

            // Carbon::parse($request->input('check_in'))->format('Y-m-d');
            $model = new Customer;
            $model->NamaCustomer = $request->input('NamaCustomer');
			$model->Email = $request->input('Email');
			$model->NoTlp = $request->input('NoTlp');
			$model->KategoriCustomer = $request->input('KategoriCustomer');
			$model->Alamat = $request->input('Alamat');
			$model->Kota = $request->input('Kota');
			$model->Point = 0;
			$model->Active = 1;
            $model->RecordOwnerID = Auth::user()->RecordOwnerID;

            $save = $model->save();

            if ($save) {
                alert()->success('Success','Data Customer disimpan.');
                return redirect('customer');
                
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
                'NamaCustomer'=>'required',
                'NoTlp'=>'required',
                'KategoriCustomer'=>'required',
                'Alamat'=>'required',
                'Kota' => 'required'
            ]);

            $model = Customer::find($request->input('id'));

            if ($model) {
                $model->NamaCustomer = $request->input('NamaCustomer');
				$model->Email = $request->input('Email');
				$model->NoTlp = $request->input('NoTlp');
				$model->KategoriCustomer = $request->input('KategoriCustomer');
				$model->Alamat = $request->input('Alamat');
				$model->Kota = $request->input('Kota');
                $update = $model->update();

                if ($update) {
                    alert()->success('Success','Data Customer berhasil disimpan.');
                    return redirect('customer');
                }else{
                    throw new \Exception('Edit Customer Gagal');
                }
            } else{
                throw new \Exception('Customer not found.');
            }
        } catch (\Exception $e) {
            Log::debug($e->getMessage());

            alert()->error('Error',$e->getMessage());
            return redirect()->back();
        }
    }

    public function Customer_delete(Request $request) {
        $user = Customer::find($request->id);

        if ($user) {
        	$user->Active = 0;
        	$save = $user->update();

        	if ($save) {
                alert()->success('Success','Delete Customer berhasil.');
                // return redirect('supplier');
            }else{
                throw new \Exception('Edit Customer Gagal');
            }
        }

        
        return redirect('customer');
    }
}
