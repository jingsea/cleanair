<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Models\Compaines;
use App\Models\Locations;

class LoginController extends Controller
{
    public function login(){
        //get all companies name_en
        $companyAll=Compaines::companyAll();
//        pp($companyAll);
        foreach ($companyAll as $v){
            $companyAll_name[]=$v->name_en;
            if($v->secure===1){
                //customer need pwd
                $companySecure_ids[]=$v->company_id;
            }else{
                //customer don't need pwd
                $companyNoSecure_ids[]=$v->company_id;
            }
        }
//        pp($companyAll_name);

        //get all locations base company


        return view('home.login',compact('companyAll_name','companySecure_ids','companyNoSecure_ids'));
    }
}
