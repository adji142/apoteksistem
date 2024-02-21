<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use DB;
use Log;
use View;

// Models
use App\Models\Company;
use App\Models\User;
use App\Models\Permission;
use App\Models\PermissionRole;
use App\Models\roles;
use App\Models\UserRole;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        View::composer('*', function($view)
        {
            // $navbars = Navbar::orderBy('ordering')->get();
            
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
                    else{
                        $temp['Detail'] = array();
                    }

                    array_push($oMenu, $temp);
                }

                // var_dump($oMenu);

                $view->with('navbars', $oMenu);

                
            }
            else{
                // throw new \Exception('Partner tidak ditemukan, Silahkan Hubungi Operator');
                return redirect('/');
            }
        });
    }
}
