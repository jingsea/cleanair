<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;


class Monitors extends Model
{
    protected $table='monitors';
    protected $primaryKey = 'monitor_id';
    public $timeStamps=false;
    //get Monitor data
    public static function monitorData(&$request)
    {
        $monitorData=DB::table('monitors')
            ->where('monitor_id',$request)
            ->select('monitor_id','name_en','monitor_type','monitor_mac','reference_mon')
            ->first();
        return $monitorData;
    }
}
