<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;



use App\Http\Requests;
use App\Services\Refresh;

use Illuminate\Support\Facades\DB;
use App\Models\Compaines;
use App\Models\Locations;
use App\Models\Monitors;
use App\Models\Readings_day;
use App\Models\Readings_hour;
use App\Models\Readings_month;
use App\Models\Readings_latest;


class IndexController extends Controller
{
    //
    public function index(Request $request)
    {
        $company_id=$request->input('c',1);
        $location_id=$request->input('l');
        $monitor_id=$request->input('m');
        $parameter=$request->input('p',0);




        //get all company_ids
        $company_ids=DB::table('companies')->lists('company_id');


        $location_ids=DB::table('locations')->where('company_id', $company_id)->lists('location_id');

        //invalid company,default haworth
        if(in_array($company_id,$company_ids) && empty($location_id)){

            $location_id=$location_ids[0];
        }else if(!in_array($company_id,$company_ids) && empty($location_id)){
            $company_id=1;
            $location_id=1;
        }else if(in_array($company_id,$company_ids) && !empty($location_id)){

            if(in_array($location_id,$location_ids)){
                $location_id=$request->input('l');
            }else{
                $company_id=1;
                $location_id=1;

            }
        }else if(!in_array($company_id,$company_ids) && !empty($location_id)){
            $company_id=1;
            $location_id=1;

        }

        $monitor_ids=Locations::monitorDataBaseLocation($location_id);


        if(!empty($monitor_id)){
            if(in_array($monitor_id,$monitor_ids)){
                $monitor_id=$request->input('m');
            }else{
                $company_id=1;
                $location_id=1;
                $monitor_id=1;
                $location=Compaines::locationDataBaseCompany($company_id);
            }

        }else{
            $monitor_id=$monitor_ids[0];
            $location=Compaines::locationDataBaseCompany($company_id);
        }
//$aa=$company_id.'--'.$location_id.'--'.$monitor_id;
//        pp($aa);



        $location=Compaines::locationDataBaseCompany($company_id);

   /*     foreach($location as $v){
            $location_ids[]=$v->location_id;
        }
//        pp($location_ids);
        $companyData=Compaines::companyData($company_id);
        $company_id=$companyData['company_id'];
        //get all locationInfo in correct company_id
        $location=Compaines::locationDataBaseCompany($company_id);
//        pp(count($location));
        foreach($location as $v){
            $locations[]=$v->location_id;
        }
//        pp($locations);
        if(!empty($location_id)){
            if(in_array($location_id,$locations)){
                $location_id=$request->input('l');
            }else{
                $company_id=1;
                $location_id=1;
                $location=Compaines::locationDataBaseCompany($company_id);
            }
        }else{
            $location_id=$locations[0];
        }

//       pp($location_id);


        $Mon=Locations::monitorDataBaseLocation($location_id);
//        pp($Mon);
        foreach($Mon as $v){
            $monitor_ids[]=$v->monitor_id;
        }
//        pp($monitor_ids);
        if(!empty($monitor_id)){
            if(in_array($monitor_id,$monitor_ids)){
                $monitor_id=$request->input('m');
            }else{
                $company_id=1;
                $location_id=1;
                $monitor_id=1;
                $location=Compaines::locationDataBaseCompany($company_id);
            }

        }else{
            $monitor_id=$monitor_ids[0];
            $location=Compaines::locationDataBaseCompany($company_id);
        }

//       pp($location);
   */
        //有关url
        $query=$request->url();

        $jumpUrl=$query.'/?c='.$company_id;

        $jumpLocUrl=$jumpUrl.'&l=';
//        pp($jumpLocUrl);
        $url=$jumpLocUrl.$location_id.'&p=';


        $companyData=Compaines::companyData($company_id);
//        pp($companyData);


        $locationData=Locations::locationData($location_id);

        $monitorData=Monitors::monitorData($monitor_id);
//        pp($monitorData);

        $readings_latestData=DB::table('readings_latest')
            ->select('reading','tvoc','co2','date_reading')
            ->where('monitor_id','=',$monitor_id)
            ->orderBy('date_reading', 'desc')
            ->first();
        $reading=$readings_latestData->reading;
        $tvoc=$readings_latestData->tvoc;
        $co2=$readings_latestData->co2;
        $date_reading=$readings_latestData->date_reading;
        

        /************get the referenceData for bottom list*****************/

        $refer_mon_id=$monitorData->reference_mon;
//        print_r($refer_mon->reference_mon);
        //get reference monitor_id
        if(empty($refer_mon_id)){
            $refer_mon_id=3;
        }// Default to Shanghai



        $referData=DB::table('monitors')
            ->join('locations','monitors.location_id','=','locations.location_id')
            ->join('readings_latest','readings_latest.monitor_id','=','monitors.monitor_id')
            ->select('locations.city','locations.name_en','monitors.location_id','readings_latest.reading','readings_latest.date_reading')
            ->where('monitors.monitor_id','=',$refer_mon_id)
            ->orderBy('readings_latest.date_reading', 'desc')
            ->first();
        $refer_city=$referData->city;
        $refer_name_en=$referData->name_en;
        $refer_reading=$referData->reading;
        $refer_reading_date=$referData->date_reading;

        $show_value='';
        if($parameter==1){
            $refer_reading=getAQIUS($refer_reading);
            $reading=getAQIUS($reading);
            $show_value='AQI US';
        }elseif($parameter==2){
            $refer_reading=getAQICN($refer_reading);
            $reading=getAQICN($reading);
            $show_value='AQI CN';
        }else{
            $show_value='PM 2.5';
        };

        /************get the latest 72 hour Data and referenceData for fusioncharts*****************/
        date_default_timezone_set('Asia/Chongqing');

        $last_readings=DB::select('select a.date_reading,a.reading,b.reading_comp from ( SELECT date_reading,  reading
                                    FROM readings_hour
                                    WHERE monitor_id =1 ) as a
                                    join
                                    ( SELECT date_reading,  reading AS reading_comp
                                    FROM readings_hour
                                    WHERE monitor_id =3 ) as b on a.date_reading=b.date_reading
                                    ORDER BY date_reading desc limit 71');



        $jsonseries = '[{"category":[';
        $jsoncol = '[';
        $jsonline = '[';


        $last_read_value = -1;
        $last_control_value = -1;

        foreach($last_readings as $k=>$v){
            $value_error = 0; // switches to 1 if there is no reading
            $control_value_error = 0; // switches to 1 if there is no reading

            $reading_time[$k]=$v->date_reading;
            $readings_base[$k]=$v->reading;
            $readings_comp[$k]=$v->reading_comp;

            $date_time["label"] = date('D H:i', strtotime($reading_time[$k]));
//            $control_value[$k] = addslashes(intval($readings_comp[$k]));
            $control_value["value"] = addslashes(intval($readings_comp[$k]));//从参考服务器上获取的数据
            if($control_value["value"] == -1)
            {
                if($last_control_value == -1)
                {
                    $control_value["value"] = "";
                }
                else
                {
                    $control_value["value"] = $last_control_value;
                    $control_value_error = 1;
                }
            }
            else
            {
                $last_control_value = $control_value["value"];
            }

            $read_value["value"] = addslashes(intval($readings_base[$k]));
            if($read_value["value"] == -1)
            {
                if($last_read_value == -1)
                {
                    $read_value["value"] = "";
                }
                else
                {
                    $read_value["value"] = $last_read_value;
                    $value_error = 1;
                }
            }
            else
            {
                $last_read_value = $read_value["value"];
            }

            if( $read_value["value"] >=0 && $read_value["value"] <= 12)
            {
                $pm2p5_color = "#00ff00";
                if($value_error == 1) 	$pm2p5_color = "#00cc00";

            }
            elseif( $read_value["value"] >12 && $read_value["value"] <= 35.5)
            {
                $pm2p5_color = "#ffff00";
                if($value_error == 1) 	$pm2p5_color = "#cccc00";

            }
            elseif( $read_value["value"] >35.5 && $read_value["value"] <= 55.5)
            {
                $pm2p5_color = "#ff9900";
                if($value_error == 1) 	$pm2p5_color = "#cc8800";

            }
            elseif( $read_value["value"] >55.5 && $read_value["value"] <= 150.5)
            {
                $pm2p5_color = "#ff0000";
                if($value_error == 1) 	$pm2p5_color = "#cc0000";

            }
            elseif( $read_value["value"] >150.5 && $read_value["value"] <= 250.5)
            {
                $pm2p5_color = "#8B008B";
                if($value_error == 1) 	$pm2p5_color = "#660066";

            }
            elseif( $read_value["value"] >250.5 && $read_value["value"] <= 500.5)
            {
                $pm2p5_color = "#B22222";
                if($value_error == 1) 	$pm2p5_color = "#a11111";

            }
            else
            {
                $pm2p5_color = "#bbbbbb";

            }
            $read_value["color"]=$pm2p5_color;

            $jsonseries .=json_encode($date_time).",";
            $jsoncol .=json_encode($read_value).",";
            $jsonline.=json_encode($control_value).",";
        }
//pp($jsonline);

        $jsonseries = substr_replace($jsonseries, '', -1); // to get rid of extra comma


        $jsonseries .= "]}]";

        $jsoncol = substr_replace($jsoncol, '', -1); // to get rid of extra comma
        $jsoncol .= "]";

        $jsonline = substr_replace($jsonline, '', -1); // to get rid of extra comma
        $jsonline .= "]";
//       pp($jsoncol);


//pp($company_id);
        $temp=in_array($request->input('c'),$company_ids);

        if(!$temp){
            return view ('home.index',compact('company_id','location_id','monitor_id','companyData','parameter','locationData','monitorData',

                'reading','tvoc','co2','date_reading','refer_city','refer_name_en','refer_reading',
                'refer_reading_date','show_value','url','jsonseries','jsoncol','jsonline','jumpUrl'));
        }else{
            if(count($location)>1){
                if ($request->has('l')) {
                    return view ('home.index',compact('company_id','location_id','monitor_id','companyData','parameter','locationData','monitorData',

                        'reading','tvoc','co2','date_reading','refer_city','refer_name_en','refer_reading',
                        'refer_reading_date','show_value','url','jsonseries','jsoncol','jsonline','jumpUrl'));
                }else{


                    return view('home.company',compact('companyData','location','jumpLocUrl'));

                }
            }else{
                return view ('home.index',compact('company_id','location_id','monitor_id','companyData','parameter','locationData','monitorData',

                    'reading','tvoc','co2','date_reading','refer_city','refer_name_en','refer_reading',
                    'refer_reading_date','show_value','url','jsonseries','jsoncol','jsonline','jumpUrl'));

            }


        }

    }


}
