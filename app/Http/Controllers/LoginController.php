<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use DB;
use Log;

// Models
use App\Models\Company;
use App\Models\User;
use App\Models\Permission;
use App\Models\PermissionRole;
use App\Models\roles;
use App\Models\UserRole;

class LoginController extends Controller
{
	public function __construct()
    {
        // $this->middleware('permission:view user', ['only' => ['user']]);
        // $this->middleware('permission:create user', ['only' => ['user_form']]);
        // $this->middleware('permission:edit user', ['only' => ['user_form']]);
        // $this->middleware('permission:delete user', ['only' => ['user_delete']]);
    }

    public function login() {
        return view("auth.login");
    }

    public function get_menu(Request $request)
    {
        $data = array('success'=> false, 'message' => '', 'data'=>array());
        // $email = $request->input('email');

        if (Auth::check()) {
            $oMenu = array();

            $oObject = UserRole::selectRaw("permission.*")
                        ->Join("permissionrole","userrole.roleid","=","permissionrole.roleid")
                        ->Join("permission","permission.id","=","permissionrole.permissionid")
                        ->Join("users","userrole.userid","=","users.id")
                        ->where("users.email","=",Auth::user()->email)
                        ->where("permission.MenuSubMenu","=","0")
                        ->where("permission.Status","=","1")
                        ->orderBy("permission.Order","asc")
                        ->get();

            foreach ($oObject as $item) {
                $temp = array();

                $temp['PermissionName'] = $item->PermissionName;
                $temp['Link'] = $item->Link;
                $temp['Icon'] = $item->Icon;

                
                if ($item->Multilevel == "1") {
                    $oObjectDetail = UserRole::selectRaw("permission.*")
                        ->Join("permissionrole","userrole.roleid","=","permissionrole.roleid")
                        ->Join("permission","permission.id","=","permissionrole.permissionid")
                        ->Join("users","userrole.userid","=","users.id")
                        ->where("users.email","=",Auth::user()->email)
                        ->where("permission.MenuSubMenu","=",$item->id)
                        ->orderBy("permission.Order","asc")
                        ->get();

                        // var_dump($oObjectDetail);
                    $tempDetail = array();
                    foreach ($oObjectDetail as $itemDetail) {

                        $x = array();

                        $x['PermissionName'] = $itemDetail->PermissionName;
                        $x['Link'] = $itemDetail->Link;
                        $x['Icon'] = $itemDetail->Icon;

                        array_push($tempDetail, $x);
                        
                    }
                    $temp['Detail'] = $tempDetail;
                }

                array_push($oMenu, $temp);
            }

            $data['success'] = true;
            $data['data'] = $oMenu;
        }
        else{
            // throw new \Exception('Partner tidak ditemukan, Silahkan Hubungi Operator');
            return redirect('/');
        }
        echo json_encode($data);
    }

    public function action_login(Request $request)
    {
        try {
            $this->validate($request, [
                'email'=>'required',
                'password'=>'required',
                'RecordOwnerID'=>'required',
            ]);

            $data = [
                'email' => $request->input('email'),
                'password' => $request->input('password'),
            ];

            // Validasi Kode Partner Exist
            $oPartner = Company::where('KodePartner','=',$request->input('RecordOwnerID'))->first();

            if (!$oPartner) {
                throw new \Exception('Partner tidak ditemukan, Silahkan Hubungi Operator');
                goto jump;
            }

            // Validasi Active Subscription

            $NowDate = Carbon::now()->toDateString();
            $DueDate = Carbon::now()->subDays($oPartner->ExtraDays)->toDateString();

            // $oPartner = DB::tables('company')
            //                 ->whereDate('EndSubs','>',$DueDate)
            //                 ->get();
            $oPartner = Company::where('EndSubs','<',$DueDate);

            if ($oPartner->count() > 0) {
                throw new \Exception('Langganan Telah Habis, Silahkan Melakukan Perpanjangan Langganan');
                goto jump;
            }

            // Validasi Email Exist
            $user = User::where('email', '=', $request->input('email'))->first();

            if ($user) {
                if ($user->active == 'N') {
                    throw new \Exception('User tidak aktif !');
                }

                if (Auth::Attempt($data)) {
                    return redirect('dashboard');
                } else{
                    throw new \Exception('Email atau Password Salah');
                }
            } else{
                throw new \Exception('Email tidak ditemukan');
            }

            jump:

        } catch (\Exception $e) {
            Log::debug($e->getMessage());
            alert()->info('Info',$e->getMessage());
            return redirect()->back();
        }
    }

    public function logout()
    {
        Auth::logout();
        return redirect('/');
    }

    public function ValidateCompany(Request $request)
    {
        $url = 'http://register.aissystem.org/home/verifyCompany';

        $postData = [
            // 'KodePartner' => $request->input('KodePartner')
            'KodePartner' => 'CL0001'
            // Add more parameters as needed
        ];

        $response = Http::post($url, $postData);

        if ($response->successful()) {
            // API request was successful, retrieve response data
            $responseData = $response->json();
            // Process the response data
            return $responseData;
        } else {
            // API request failed, handle the error
            $statusCode = $response->status();
            $errorMessage = $response->body();
            // Handle the error as needed
            return response()->json(['error' => $errorMessage], $statusCode);
        }
    }
}
