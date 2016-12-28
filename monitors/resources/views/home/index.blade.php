<!DOCTYPE html>
<html>
<head>
    <title>CleanAir Spaces Monitoring - {{ $companyData->name_en }}</title>
    <meta http-equiv="content-type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=1600" />
    {{--<script src="{{ asset('/assets/js/jquery-1.12.0.min.js') }}"></script>--}}
    <script src="{{ asset('/assets/js/jquery-1.12.0.min.js') }}"></script>

    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="{{ asset('/assets/css/bootstrap.min.css') }}" tppabs="{{ asset('/assets/css/bootstrap.min.css') }}">
    <!-- Optional theme -->
    <link rel="stylesheet" href="{{ asset('/assets/css/bootstrap-theme.min.css') }}" tppabs="{{ asset('/assets/css/bootstrap-theme.min.css') }}">
    <!-- Latest compiled and minified JavaScript -->
    <script src="{{ asset('/assets/js/bootstrap.min.js') }}" tppabs="{{ asset('/assets/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('/assets/js/cleanair.js') }}" tppabs="{{ asset('/assets/js/cleanair.js') }}"></script>
    <link rel="stylesheet" media="all" href="{{ asset('/assets/css/cleanair.css') }}" tppabs="{{ asset('/assets/css/cleanair.css') }}" data-turbolinks-track="true" />
    <script type="text/javascript" src="{{ asset('/assets/js/fusioncharts/js/fusioncharts.js') }}"></script>
    <script type="text/javascript" src="{{ asset('/assets/js/fusioncharts/js/themes/fusioncharts.theme.fint.js') }}"></script>
    <script src="{{ asset('/assets/js/circle-progress.min.js') }}"></script>
    <script src="{{ asset('/assets/js/default.js') }}" type="text/javascript"></script>
</head>
<body>
<div id="body" style="background: url(/assets/images/picture/{{ $locationData->picture }}) no-repeat center center; background-size: cover;">
    <!--
    <div id="header">Top
    </div>
  -->

    <div class="left hidden-xs" id="left" >
        <div class="glyphicon-yen" id="buttonbar">
            <button type="button" class="btn btn-primary btn-sm" data-toggle="collapse" href="#chart_panel" >View History</button>
            <div class="btn-group">
                <button type="button" class="btn btn-primary btn-sm">{{ $show_value }}</button>
                <button type="button" class="btn btn-primary btn-sm dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <span class="caret"></span> <span class="sr-only">Toggle Dropdown</span> </button>
                <ul class="dropdown-menu">
                    <li><a href="{{ $url }}0">PM 2.5</a></li>
                    <li><a href="{{ $url }}1">AQI US</a></li>
                    <li><a href="{{ $url }}2">AQI CN</a></li>
                </ul>
            </div>
        </div>
        <div class="chart_panel collapse" id="chart_panel">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <h3 class="panel-title">History Chart</h3>
                    <span class="pull-right clickable"><i class="glyphicon glyphicon-remove-sign" data-toggle="collapse" href="#chart_panel" ></i></span> </div>
                <div class="panel-body">
                    <!--
                                <h5>Outside Concentration</h5>
                                <div class="btn-group btn-toggle">
                                  <button class="btn btn-xs btn-default">ON</button>
                                  <button class="btn btn-xs btn-primary active">OFF</button>
                                </div>
                                <hr>
          -->
                    <div style="padding:10px 10px 10px 10px;">
                        <div id="chartContainer">FusionCharts XT will load here!

         <input type="hidden" id="jsonseries" name="jsonseries" value="{{ $jsonseries }} " />
         <input type="hidden" id="jsoncol" name="jsoncol" value="{{ $jsoncol }} " />
        <input type="hidden" id="refer_city" name="refer_city" value="{{ $locationData->city }} " />
        <input type="hidden" id="refer_name_en" name="refer_name_en" value="{{ $locationData->name_en }} " />
        <input type="hidden" id="reference_city" name="reference_city" value="{{ $refer_name_en }} " />
        <input type="hidden" id="jsonline" name="jsonline" value="{{ $jsonline }} " />

        <input type="hidden" id="company_id" name="company_id" value="{{ $company_id }} " />
        <input type="hidden" id="location_id" name="location_id" value="{{ $location_id }} " />
        <input type="hidden" id="monitor_id" name="monitor_id" value="{{ $monitor_id }} " />
        <input type="hidden" id="parameter" name="parameter" value="{{ $parameter }} " />


                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="right" id="right"><br>
        <div id="cust_logo"> <a href = "{{url($jumpUrl)}}"> <img src="/assets/images/logo/{{ $companyData->logo }}" alt="" style="width: auto; height: auto; max-height: 75px;max-width: 370px;"/> </a> </div>
        <div class="readings_contents" id="readings_contents">
            <div class="readings_container" id="readings_container">
                <div class="readings_box">
                    <div><span class="readings_loctext">{{ $locationData->city }} - {{ $locationData->name_en }}</span></div>
                    <div class="hr_half"></div>
                    <br>
                    <center>
                        <div id="indoor_circle" class="indoor_circle">
                            <div id="indoor_circle_param" class="param">
                                {{ $show_value }}
                                </div>
                            <div id="indoor_circle_value" class="value">

                                    {{ $reading }}

                            </div>
                            <div id="indoor_circle_measure" class="measure">µg/m³</div>
                        </div>
                    </center>
                    <button id="indoor_btn" type="button" class="btn" data-toggle="modal" data-target="#statusExplain" style="width:100%;padding-left:40px;padding-right:40px;color: #ffffff; background-color: #ff0000;text-transform: uppercase; position: relative; z-index: 50">Good</button>
                    <div class="hr_center"></div>
                    <center>
                        <div id="indoor_other" class="indoor_other">
                            <div id="indoor_left" class="indoor_left">
                                <div id="indoor_left_content" class="indoor_left_content">
                                    {{ $show_value }}
                                    <br>
                                    {{ $reading }} </div>
                                <div id="indoor_hr_left" class="indoor_hr_left"></div>
                            </div>
                            <div id="indoor_middle" class="indoor_middle">
                         <div id="indoor_middle_content" class="indoor_middle_content">
                                     TVOC<br>
                                     {{ $tvoc }} µg/m³</div>
                        <div id="indoor_hr_center" class="indoor_hr_center"></div></div>
                            <div id="indoor_right" class="indoor_right">
                                <div id="indoor_right_content" class="indoor_right_content"> CO2<br>
                                    {{ $co2 }} ppm</div>
                                <div id="indoor_hr_right" class="indoor_hr_right"></div>
                            </div>
                        </div></center>
                    <div id="indoor_readings_time" class="indoor_readings_time">Last Updated on {{ $date_reading }}</div>
                </div>
                <div class="readings_box" style="background-color: rgba(299, 255, 255, 0.1);">
                    <div><span class="readings_loctext">{{ $refer_city }} - {{ $refer_name_en }}</span></div>
                    <div class="hr_half"></div>
                    </br>
                    <center>
                        <div id="outdoor_circle" class="outdoor_circle" >
                            <div id="outdoor_circle_param" class="param">
                                {{ $show_value }}
                            </div>
                            <div id="outdoor_circle_value" class="value">{{ $refer_reading }}</div>
                            <div id="outdoor_circle_measure" class="measure">µg/m³</div>
                        </div>
                    </center>
                    <button id="outdoor_btn" type="button" class="btn" data-toggle="modal" data-target="#statusExplain" style="width:100%;padding-left:40px;padding-right:40px;color: #ffffff; background-color: #ff0000;text-transform: uppercase;position: relative; z-index: 50">Unhealthy</button>
                    <div class="outdoor_readings_time">Last Updated on {{ $refer_reading_date }}</div>
                </div>
            </div>
        </div>
    </div>
    <div id="footer" > <img src="{{asset('/assets/images/cleanairspaceslogo.png')}}" style="width: auto; height: auto; max-height: 55px;max-width: 700px;"> </div>
</div>

<!-- Modal -->
<div class="modal fade" id="statusExplain" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Color Status Explanation</h4>
            </div>
            <div class="modal-body">
                <button type="button" class="btn" style="width:100%;padding-left:40px;padding-right:40px;color:#000000; background-color: #00ff00;text-transform: uppercase;">GOOD</button>
                <dl class="dl-horizontal">
                    <dt>Outdoor Exercise</dt>
                    <dd>Recommended</dd>
                    <dt>Masks</dt>
                    <dd>Unnecessary</dd>
                    <dt>Kids/Elders</dt>
                    <dd>Suitable for Outdoor Activities</dd>
                    <dt>Air Purifier</dt>
                    <dd>Unnecessary</dd>
                    <dt>Ventilation</dt>
                    <dd>Recommended</dd>
                </dl>
                <hr>
                <button type="button" class="btn" style="width:100%;padding-left:40px;padding-right:40px;color:#000000; background-color: #ffff00;text-transform: uppercase;">MODERATE</button>
                <dl class="dl-horizontal">
                    <dt>Outdoor Exercise</dt>
                    <dd>Recommended</dd>
                    <dt>Masks</dt>
                    <dd>Unnecessary</dd>
                    <dt>Kids/Elders</dt>
                    <dd>Suitable for Outdoor Activities</dd>
                    <dt>Air Purifier</dt>
                    <dd>Unnecessary</dd>
                    <dt>Ventilation</dt>
                    <dd>Recommended</dd>
                </dl>
                <hr>
                <button type="button" class="btn" style="width:100%;padding-left:40px;padding-right:40px;color:#000000; background-color: #ff9900;text-transform: uppercase;">Unhealthy for Sensitive Groups</button>
                <dl class="dl-horizontal">
                    <dt>Outdoor Exercise</dt>
                    <dd>Not Recommended</dd>
                    <dt>Masks</dt>
                    <dd>Unnecessary</dd>
                    <dt>Kids/Elders</dt>
                    <dd>Avoid Outdoor Activities</dd>
                    <dt>Air Purifier</dt>
                    <dd>Unnecessary but Recommended</dd>
                    <dt>Ventilation</dt>
                    <dd>Suitable</dd>
                </dl>
                <hr>
                <button type="button" class="btn" style="width:100%;padding-left:40px;padding-right:40px;color:#ffffff; background-color: #ff0000;text-transform: uppercase;">Unhealthy</button>
                <dl class="dl-horizontal">
                    <dt>Outdoor Exercise</dt>
                    <dd>Not Suitable</dd>
                    <dt>Masks</dt>
                    <dd>Recommended</dd>
                    <dt>Kids/Elders</dt>
                    <dd>Avoid Outdoor Activities</dd>
                    <dt>Air Purifier</dt>
                    <dd>Recommended</dd>
                    <dt>Ventilation</dt>
                    <dd>Not Recommended</dd>
                </dl>
                <hr>
                <button type="button" class="btn" style="width:100%;padding-left:40px;padding-right:40px;color:#ffffff; background-color: #8B008B;text-transform: uppercase;">Very Unhealthy</button>
                <dl class="dl-horizontal">
                    <dt>Outdoor Exercise</dt>
                    <dd>Not Suitable</dd>
                    <dt>Masks</dt>
                    <dd>Necessary</dd>
                    <dt>Kids/Elders</dt>
                    <dd>Avoid Outdoor Activities</dd>
                    <dt>Air Purifier</dt>
                    <dd>Necessary</dd>
                    <dt>Ventilation</dt>
                    <dd>Not Recommended</dd>
                </dl>
                <hr>
                <button type="button" class="btn" style="width:100%;padding-left:40px;padding-right:40px;color:#ffffff; background-color: #B22222;text-transform: uppercase;">Hazardous</button>
                <dl class="dl-horizontal">
                    <dt>Outdoor Exercise</dt>
                    <dd>Not Suitable</dd>
                    <dt>Masks</dt>
                    <dd>Necessary</dd>
                    <dt>Kids/Elders</dt>
                    <dd>Avoid Outdoor Activities</dd>
                    <dt>Air Purifier</dt>
                    <dd>Necessary</dd>
                    <dt>Ventilation</dt>
                    <dd>Not Recommended</dd>
                </dl>
                <hr>
                <button type="button" class="btn" style="width:100%;padding-left:40px;padding-right:40px;color:#ffffff; background-color: #bbbbbb;text-transform: uppercase;">Beyond Rating</button>
                <dl class="dl-horizontal">
                    <dt>Outdoor Exercise</dt>
                    <dd>Not Suitable</dd>
                    <dt>Masks</dt>
                    <dd>Necessary</dd>
                    <dt>Kids/Elders</dt>
                    <dd>Avoid Outdoor Activities</dd>
                    <dt>Air Purifier</dt>
                    <dd>Necessary</dd>
                    <dt>Ventilation</dt>
                    <dd>Not Recommended</dd>
                </dl>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>



</body>
</html>
