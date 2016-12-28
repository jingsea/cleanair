<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Compaines;
use App\Locations;

class CompanyController extends Controller
{
    public function companyData(Request $request)
    {
//        $company_id = $request->input('c',1);
        $url = $request->url();

        //get company
        $companyData=Compaines::companyData($company_id);
        $name_en=$companyData['name_en'];
        $picture=$companyData['picture'];
        $logo=$companyData['logo'];
        //get locationInfo
        $locationData=Compaines::locationData($company_id);


        return view('home.company',compact('name_en','picture','logo','locationData','url'));

    }
    public function locationData(Request $request,$location_id)
    {
        $locationData=Locations::locationData($location_id);
        $loc_name_en=$locationData['name_en'];
        $loc_picture=$locationData['picture'];

        return view('home.company',compact('loc_name_en','loc_picture'));

    }
}
