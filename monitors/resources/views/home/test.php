function insertPM25_Chart($monitor_id, $mon_city, $mon_desc, $mon_ref)
{

//
// 1. Read all values for the last 24 hours for the selected monitor
// 2. Read all values for the control monitor (Same city)
// 3. Create array If any of the values is missing, use the previous value
// 4. Create JSON string that shows time and values
// 5. Create Javascript text with values
//

if($mon_ref > 0)
{
$refmoninfo = getMonitorInfo($mon_ref);
$ref_location = $refmoninfo['name_en'];
}
else
{
$mon_ref = 3; // Default to Shanghai
}


$readings = get_last24_pm25($monitor_id,$mon_ref);


// Create New arrays

$reading_time = array();
$readings_base = array();//当前值
$readings_comp = array();//参考值

//$jsontext = "[";
$jsonseries = '"categories": [{"category": [';
$jsoncol = '"dataset": [{"seriesName": "'.$mon_city . " - " . $mon_desc .'", "showValues": "1", "renderAs": "column","data": [';
$jsonline = '{"seriesName": "'.$ref_location.'","renderAs": "spline","showValues": "0","data": [';

//
// Process for each reading
//

date_default_timezone_set('Asia/Chongqing');

$last_read_value = -1;
$last_control_value = -1;

for($i=0; $i<count($readings); $i++)
{

$value_error = 0; // switches to 1 if there is no reading
$control_value_error = 0; // switches to 1 if there is no reading

// Get average PM2.5 (monitor, parameter, >=time start, <time end)
                                                              array_push($reading_time,$readings[$i]['date_reading']);
array_push($readings_base,$readings[$i]['reading']);
array_push($readings_comp,$readings[$i]['reading_comp']);

$date_time = date('D H:i', strtotime($readings[$i]['date_reading']));

$control_value = addslashes(intval($readings[$i]['reading_comp']));//从参考服务器上获取的数据
if($control_value == -1)
{
if($last_control_value == -1)
{
$control_value = "";
}
else
{
$control_value = $last_control_value;
$control_value_error = 1;
}
}
else
{
$last_control_value = $control_value;
}

$read_value = addslashes(intval($readings[$i]['reading']));
if($read_value == -1)
{
if($last_read_value == -1)
{
$read_value = "";
}
else
{
$read_value = $last_read_value;
$value_error = 1;
}
}
else
{
$last_read_value = $read_value;
}

if( $read_value >=0 && $read_value <= 12)
{
$pm2p5_color = "#00ff00";
if($value_error == 1) 	$pm2p5_color = "#00cc00";
}
elseif( $read_value >12 && $read_value <= 35.5)
{
$pm2p5_color = "#ffff00";
if($value_error == 1) 	$pm2p5_color = "#cccc00";
}
elseif( $read_value >35.5 && $read_value <= 55.5)
{
$pm2p5_color = "#ff9900";
if($value_error == 1) 	$pm2p5_color = "#cc8800";
}
elseif( $read_value >55.5 && $read_value <= 150.5)
{
$pm2p5_color = "#ff0000";
if($value_error == 1) 	$pm2p5_color = "#cc0000";
}
elseif( $read_value >150.5 && $read_value <= 250.5)
{
$pm2p5_color = "#8B008B";
if($value_error == 1) 	$pm2p5_color = "#660066";
}
elseif( $read_value >250.5 && $read_value <= 500.5)
{
$pm2p5_color = "#B22222";
if($value_error == 1) 	$pm2p5_color = "#a11111";
}
else
{
$pm2p5_color = "#bbbbbb";
}


$jsonseries .= '{"label": "'.addslashes($date_time).'"},'."\n";
$jsoncol .= '{"value": "'.$read_value.'", "color": "'.$pm2p5_color.'"},'."\n";
$jsonline .= '{"value": "'.$control_value.'"},'."\n";

}
//$jsontext = substr_replace($jsontext, '', -1); // to get rid of extra comma
//$jsontext .= "]";

$jsonseries = substr_replace($jsonseries, '', -2); // to get rid of extra comma
$jsonseries .= "]}],";

$jsoncol = substr_replace($jsoncol, '', -2); // to get rid of extra comma
$jsoncol .= "]},";

$jsonline = substr_replace($jsonline, '', -2); // to get rid of extra comma
$jsonline .= "]}]";

$jsontext = $jsonseries . $jsoncol . $jsonline;

echo '
<script type="text/javascript" >

    FusionCharts.ready(function(){
        var revenueChart = new FusionCharts({
            "type": "scrollcombi2d",
            "renderAt": "chartContainer",
            "width": "100%",
            "height": "300",
            "dataFormat": "json",
            "dataSource": {
                "chart": {
                    "caption": "'. $mon_city . " - " . $mon_desc .'",
                    "subCaption": "PM 2.5 Last 72 Hours",
                    "xAxisName": "Hour",
                    "yAxisName": "PM 2.5",
                    "numVisiblePlot" : "24",
                    "scrollheight" : "15",
                    "flatScrollBars" : "0",
                    "scrollShowButtons" : "1",
                    "scrollColor" : "#ddddff",
                    "scrollToEnd" : "1",
                    "theme": "fint",
                    "labelStep": "3"
                },'. $jsontext .'
            }
        });

        revenueChart.render();
    })

</script>
';

}