<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;

use App\Http\Requests;
use App\Models\Locations;
use Illuminate\Support\Facades\DB;

class LocationController extends Controller
{
    //
    public  function location(Request $request)
    {
        $company_id=$request->input('c',1);
        //get all location_ids for company
        $loaction_ids=DB::table('locations')->where('company_id',$company_id)->lists('location_id');
//       pp(count($loaction_ids));

        // if location_ids>1
        if (count($loaction_ids)>1){

            foreach($loaction_ids as $k=>$v){
                //get monitor_ids for every location
                $monitor_ids[$v]=DB::table('monitors')->where('location_id',$v)->lists('monitor_id');
//                pp($monitor_ids);
                $loc_reading=array();
                $reading=array();
                foreach($monitor_ids[$v] as $v){

                    $loc_reading[]=DB::table('readings_latest')->where('monitor_id',$v)
                        ->select('reading')->orderBy('rl_id','DESC') ->first();

                }
//                delete null
                $loc_reading=array_filter($loc_reading);
//            pp($loc_reading);
                foreach($loc_reading as $v){
                    $reading[]=$v->reading;
                }

                $readings_all=array_sum($reading);

                $count=count($reading);

                $reading_avg[]=intval($readings_all/$count);

            }

//pp($reading_avg);  Array ( [0] => 45 [1] => 54 [2] => 66 [3] => 69 [4] => 68 )
        }else if(count($loaction_ids)==1){
            // if location_ids=1

        }

    }
}
