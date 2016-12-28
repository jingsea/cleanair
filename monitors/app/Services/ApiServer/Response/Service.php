<?php
/**
 * Created by PhpStorm.
 * User: HP
 * Date: 2016/11/23
 * Time: 11:28
 */
namespace App\Services\ApiServer\Response;


use Illuminate\Http\Request;
use App\Http\Requests;
use App\Models\Locations;
use App\Models\Compaines;
use Illuminate\Support\Facades\DB;



class Service
{
    /* *
     *  get company
     */
    public static function getCompany(&$request)
    {
        $data=null;
        if (!empty($request['name'])) {
            $data=DB::table('companies')
                ->select('name_en','secure','company_id')
                ->where('name_en', 'like', '%' . $request['name'] . '%')
                ->first();
        }
        $data=json_encode($data);
        return $data;
    }
    /* *
    *  get Locations
    */
    public static function getLocation(&$request)
    {
      //  dd($request);
        $result = array(
            'code'  => 0,
            'data'  => null
        );
        $request['company_id']=intval($request['company_id']);
        $_data=DB::table('companies')
                    ->select('user','password','company_id')
                    ->where('company_id',$request['company_id'])
                    ->first();
//        dd($_data);
        if($_data){
            if(!empty($_data->user)){
                if($_data->user==$request['user'] && $_data->password==$request['password']){
                    $result['data']=DB::table('locations')
                        ->where('company_id',$request['company_id'])
                        ->select('location_id','name_en')
                        ->get();
                    $result['code']=1;
                }else{
                    $result['code']=0;
                }
            }else{
                $result['data']=DB::table('locations')
                    ->where('company_id',$request['company_id'])
                    ->select('location_id','name_en')
                    ->get();
                $result['code']=1;
            }
        }

        $result=json_encode($result);
        return $result;
    }
    /* *
    *  get Monitors
    */
    public static function getMonitors(&$request)
    {
        $result = array(
            'code'  => 1,
            'data'  => null
        );
        $request['location_id']=intval($request['location_id']);
        $_data=DB::table('locations')
            ->join('companies','locations.company_id','=','companies.company_id')
            ->select('locations.location_id','companies.user','companies.password')
            ->where('location_id',$request['location_id'])
            ->first();
       /* $_data=DB::select('SELECT a.location_id ,b.user,b.password,b.company_id FROM `locations` a
join companies b on a.company_id=b.company_id where location_id='.$request['location_id']);*/
//        pp($_data);
        if($_data){
            if(!empty($_data->user)){
                if($_data->user==$request['user'] && $_data->password==$request['password']){
                    $result['data']=DB::table('monitors')
                        ->where('location_id',$request['location_id'])
                        ->select('monitor_id','name_en','reference_mon')
                        ->get();
                    $result['code']=1;
                }else{
                    $result['code']=0;
                }
            }else{
                $result['data']=DB::table('monitors')
                    ->where('location_id',$request['location_id'])
                    ->select('monitor_id','name_en','reference_mon')
                    ->get();
                $result['code']=1;
            }
        }
        $result=json_encode($result);
        return $result;
    }
    /* *
     *  get Latest_Info
     */
    public static function getLatest(&$request)
    {
        $result = array(
            'code'  => 1,
            'data'  => null
        );
        $request['monitor_id']=intval($request['monitor_id']);
        $_data=DB::table('monitors')
            ->join('locations','locations.location_id','=','monitors.location_id')
            ->join('companies','locations.company_id','=','companies.company_id')
            ->select('monitors.monitor_id','companies.user','companies.password')
            ->where('monitor_id',$request['monitor_id'])
            ->first();
        if($_data){
            if(!empty($_data->user)){
                if($_data->user==$request['user'] && $_data->password==$request['password']){
                    $result['data']=DB::table('readings_latest')
                        ->where('monitor_id',$request['monitor_id'])
                        ->select('monitor_id','reading','temperature','humidity','tvoc','co2','co')
                        ->orderBy('date_reading','desc')
                        ->first();
                    $result['code']=1;
                }else{
                    $result['code']=0;
                }
            }else{
                $result['data']=DB::table('readings_latest')
                    ->where('monitor_id',$request['monitor_id'])
                    ->select('monitor_id','reading','temperature','humidity','tvoc','co2','co')
                    ->orderBy('date_reading','desc')
                    ->first();
                $result['code']=1;
            }
            $result=json_encode($result);
            return $result;
        }


    }


}