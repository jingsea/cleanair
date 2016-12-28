<?php
/**
 * Created by PhpStorm.
 * User: HP
 * Date: 2016/11/29
 * Time: 15:05
 */



use Illuminate\Http\Request;
use App\Http\Requests;
use App\Locations;
use App\Compaines;
use Illuminate\Support\Facades\DB;
class Refresh
{
    /* *
    *  get latestData
    */
    public static function getlatestData(&$company_id,&$location_id,&$monitor_id,&$parameter)
    {
//        pp($parameter);

        $customer = $company_id;
        $location = $location_id;
        $monitor = $monitor_id;
        $param = $parameter;
        $loc_specified = false;
        $data = null;
        if ($customer === "" || $customer === false || $customer === null) {
            //$customer is null
            $customer = 1;
            $location = "";

            $monitors = DB::select("select monitor_id from monitors where location_id in
                                  (select location_id from locations where company_id = " . $customer . ")");
            $custInfo = DB::table('companies')
            ->select('company_id','name_en','name_cn','logo','picture','secure','user','password')
            ->where('company_id',$customer)
            ->first();

        } else { //$customer is not null

            if ($location === "" || $location === false || $location === null) {
                //
                // We received a customer_ID, make sure it is valid
                //
                $monitors = DB::select("select monitor_id from monitors where location_id in
                                  (select location_id from locations where company_id = " . $customer . ")");
                $custInfo = DB::table('companies')
                    ->select('company_id','name_en','name_cn','logo','picture','secure','user','password')
                    ->where('company_id',$customer)
                    ->first();

                if (count($monitors) == 0) {
                    //
                    // Customer ID not valid, default to HWS
                    //
                    $customer = 1;
                    $location = "";
                    $monitors = DB::select("select monitor_id from monitors where location_id in
                                  (select location_id from locations where company_id = " . $customer . ")");
                    $custInfo = DB::table('companies')
                        ->select('company_id','name_en','name_cn','logo','picture','secure','user','password')
                        ->where('company_id',$customer)
                        ->first();
                }

            } else {
                // We have customer and Location.
                // First verify that the location really belongs to the customer
                $monitors = DB::select("select monitor_id from monitors where location_id in (select location_id from locations where company_id = " . $customer . " and location_id = $location)");
                $custInfo =  DB::table('companies')
                    ->select('company_id','name_en','name_cn','logo','picture','secure','user','password')
                    ->where('company_id',$customer)
                    ->first();
                $locInfo = DB::table('locations')
                    ->select('location_id','company_id','name_en','name_cn','city','picture')
                    ->where('location_id',$location)
                    ->first();

//                $loc_specified = true;

                if (count($monitors) == 0) {
                    //
                    // Either no monitors or customer/location combination bad. default to HWS
                    //
                    $customer = 1;
                    $location = "";

                    // select monitor_id from monitors where location_id in (select location_id from locations where company_id = $customer)

                    $monitors =  DB::select("select monitor_id from monitors where location_id in
                                  (select location_id from locations where company_id = " . $customer . ")");

                    $custInfo = DB::table('companies')
                        ->select('company_id','name_en','name_cn','logo','picture','secure','user','password')
                        ->where('company_id',$customer)
                        ->first();
                    $loc_specified = false;
                }
            }
        }


        // Use the picture selected at the customer level by each customer
        if ($loc_specified == true) {
            $backimage = $locInfo->picture;
        } else {
            $backimage = $custInfo->picture;
        }

        $custName = $custInfo->name_en;
        $monitors=json_encode($monitors);
      $monitors=json_decode($monitors,true);
//        pp($monitors[0]);
        $monInfo = DB::select("select monitors.*, locations.city from monitors inner join locations on
(monitors.location_id = locations.location_id) where monitor_id = " . $monitors[0]['monitor_id'] );
//        pp($monInfo);
        $mon_chart = $monitors[0]['monitor_id'];
        $mon_city = $monInfo[0]->city;
        $mon_desc = $monInfo[0]->name_en;
        $mon_ref = $monInfo[0]->reference_mon;

        $pm2p5_level = 1;


        for ($i = 0; $i < count($monitors); $i++) {

            $monInfo = DB::select("select monitors.*, locations.city from monitors inner join locations on
(monitors.location_id = locations.location_id) where monitor_id = " . $monitors[$i]['monitor_id'] );
            $latestReading = DB::table('readings_latest')
                ->select('date_reading','reading','co2','tvoc')
                ->where('monitor_id',$monitors[$i]['monitor_id'])
                ->orderBy('rl_id','DESC')
                ->first();


            $value = intval($latestReading->reading);
            $tvoc = intval($latestReading->tvoc);
            $co2 = intval($latestReading->co2);
            $city = $monInfo[0]->city;;
            $description = $monInfo[0]->name_en;
            $lastupdate = $latestReading->date_reading;
            $pm2p5_label = "";
            $pm2p5_labelcolor = "";
            $pm2p5_color = "";
            $pm2p5_level = 0.5;

            if ($value >= 0 && $value <= 12) {
                $pm2p5_label = "Good";
                $pm2p5_labelcolor = "#000000";
                $pm2p5_color = "#00ff00";
            } elseif ($value > 12 && $value <= 35.5) {
                $pm2p5_label = "Moderate";
                $pm2p5_labelcolor = "#000000";
                $pm2p5_color = "#ffff00";
                $pm2p5_level = 1.5;
            } elseif ($value > 35.5 && $value <= 55.5) {
                $pm2p5_label = "Unhealthy for Sensitive Groups";
                $pm2p5_labelcolor = "#ffffff";
                $pm2p5_color = "#ff9900";
                $pm2p5_level = 2.5;
            } elseif ($value > 55.5 && $value <= 150.5) {
                $pm2p5_label = "Unhealthy";
                $pm2p5_labelcolor = "#ffffff";
                $pm2p5_color = "#ff0000";
                $pm2p5_level = 4;
            } elseif ($value > 150.5 && $value <= 250.5) {
                $pm2p5_label = "Very Unhealthy";
                $pm2p5_labelcolor = "#ffffff";
                $pm2p5_color = "#8B008B";
                $pm2p5_level = 5;
            } elseif ($value > 250.5 && $value <= 500.5) {
                $pm2p5_label = "Hazardous";
                $pm2p5_labelcolor = "#ffffff";
                $pm2p5_color = "#B22222";
                $pm2p5_level = 6;
            } else {
                $pm2p5_label = "Beyond Rating";
                $pm2p5_labelcolor = "#000000";
                $pm2p5_color = "#bbbbbb";
                $pm2p5_level = 6;
            }

            $param_label = "PM 2.5";
            $display_param = $value;

            if ($param == 1) {
                $display_param = getAQIUS($value);
                $param_label = " AQI US";
            }

            if ($param == 2) {
                $display_param = getAQICN($value);
                $pm2p5_level = getAQICN_Level($value);
                $pm2p5_labelcolor = getAQICN_LabelColor($pm2p5_level);
                $pm2p5_label = getAQICN_Label($pm2p5_level);
                $pm2p5_color = getAQICN_Color($pm2p5_level);
                $param_label = " AQI CN";
            }

            $data='{"indoor":{"indoor_pm":"' . $value . '","indoor_level":"' . $pm2p5_level . '","indoor_co2":"' . $co2 . '","indoor_voc":"' . $tvoc . '","indoor_color":"' . $pm2p5_color . '","indoor_textcolor":"' . $pm2p5_labelcolor . '","indoor_text":"' . $pm2p5_label . '","indoor_time":"' . $lastupdate . '","param_label":"' . $param_label . '","display_param":"' . $display_param . '"},';
//            $data=json_encode($data);
//            pp($data);
//            return $data;

        }
//        pp($data);
        if (count($monitors) == 1) {
            // Show the reference monitor (Outdoor AQI)
            $monInfo = DB::select("select monitors.*, locations.city from monitors inner join locations on
(monitors.location_id = locations.location_id) where monitor_id = " . $mon_ref );
//            pp($monInfo );
            $latestReading = DB::table('readings_latest')
                ->select('date_reading','reading','co2','tvoc')
                ->where('monitor_id',$mon_ref)
                ->orderBy('rl_id','DESC')
                ->first();

            $value = intval($latestReading->reading);
            $city = $monInfo[0]->city;
            $description = $monInfo[0]->name_en;
            $lastupdate = $latestReading->date_reading;
            $pm2p5_label = "";
            $pm2p5_labelcolor = "";
            $pm2p5_color = "";
            $pm2p5_level = 0.5;

            if ($value >= 0 && $value <= 12) {
                $pm2p5_label = "Good";
                $pm2p5_labelcolor = "#000000";
                $pm2p5_color = "#00ff00";
            } elseif ($value > 12 && $value <= 35.5) {
                $pm2p5_label = "Moderate";
                $pm2p5_labelcolor = "#000000";
                $pm2p5_color = "#ffff00";
                $pm2p5_level = 1.5;
            } elseif ($value > 35.5 && $value <= 55.5) {
                $pm2p5_label = "Unhealthy for Sensitive Groups";
                $pm2p5_labelcolor = "#ffffff";
                $pm2p5_color = "#ff9900";
                $pm2p5_level = 2.5;
            } elseif ($value > 55.5 && $value <= 150.5) {
                $pm2p5_label = "Unhealthy";
                $pm2p5_labelcolor = "#ffffff";
                $pm2p5_color = "#ff0000";
                $pm2p5_level = 4;
            } elseif ($value > 150.5 && $value <= 250.5) {
                $pm2p5_label = "Very Unhealthy";
                $pm2p5_labelcolor = "#ffffff";
                $pm2p5_color = "#8B008B";
                $pm2p5_level = 5;
            } elseif ($value > 250.5 && $value <= 500.5) {
                $pm2p5_label = "Hazardous";
                $pm2p5_labelcolor = "#ffffff";
                $pm2p5_color = "#B22222";
                $pm2p5_level = 6;
            } else {
                $pm2p5_label = "Beyond Rating";
                $pm2p5_labelcolor = "#000000";
                $pm2p5_color = "#bbbbbb";
                $pm2p5_level = 6;
            }

            $param_label = "PM 2.5";
            $display_param = $value;

            if ($param == 1) {
                $display_param = getAQIUS($value);
                $param_label = " AQI US";
            }

            if ($param == 2) {
                $display_param = getAQICN($value);
                $pm2p5_level = getAQICN_Level($value);
                $pm2p5_labelcolor = getAQICN_LabelColor($pm2p5_level);
                $pm2p5_label = getAQICN_Label($pm2p5_level);
                $pm2p5_color = getAQICN_Color($pm2p5_level);
                $param_label = " AQI CN";
            }


//
//
// OUTDOOR DATA
//
//
            $data.='"outdoor":{"outdoor_pm":"' . $value . '","outdoor_level":"' . $pm2p5_level . '","outdoor_co2":"' . $co2 . '","outdoor_voc":"' . $tvoc . '","outdoor_color":"' . $pm2p5_color . '","outdoor_textcolor":"' . $pm2p5_labelcolor . '","outdoor_text":"' . $pm2p5_label . '","outdoor_time":"' . $lastupdate . '","param_label":"' . $param_label . '","display_param":"' . $display_param . '"}}';


//           pp($data);

            $data = json_encode($data);
            return $data;

        }
    }
}
