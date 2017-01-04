<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Compaines extends Model
{
    //
    protected $table='companies';
    protected $primaryKey = 'company_id';
    public $timeStamps=false;

    //get Company data
    public static function companyData(&$request)
    {
        $companyData=DB::table('companies')
            ->where('company_id',$request)
            ->select('company_id','name_en','picture','logo','secure','user','password')
            ->first();
       return $companyData;
    }
    //get Location data
    public static function locationDataBaseCompany(&$request)
    {
        $locationDataBaseCompany=DB::table('locations')
            ->where('company_id', $request)
            ->select('location_id','picture','name_en')
            ->get();

        return $locationDataBaseCompany;
    }
}
