<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Locations extends Model
{
    protected $table='locations';
    protected $primaryKey = 'location_id';
    public $timeStamps=false;
    //get Location data
    public static function locationData(&$request)
    {
        $locationData=DB::table('locations')
            ->where('location_id',$request)
            ->select('location_id','name_en','picture','city')
            ->first();
        return $locationData;
    }
    //get Mon data
    public static function monitorDataBaseLocation(&$request)
    {
        $monitorDataBaseLocation=DB::table('monitors')->where('location_id', $request)->lists('monitor_id');


        return $monitorDataBaseLocation;
    }
}
