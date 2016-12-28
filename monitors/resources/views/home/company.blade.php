<!DOCTYPE html>
<html>
<head>
    <title>CleanAir Spaces Monitoring - {{ $companyData->name_en }}</title>
    <meta http-equiv="content-type" content="text/html; charset=utf-8" />

    <meta name="viewport" content="width=1600" />

    <script src="{{ asset('/assets/js/jquery.min.js') }}"></script>

    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="{{ asset('/assets/css/bootstrap.min.css') }}" tppabs="{{ asset('/assets/css/bootstrap.min.css') }}">
    <!-- Optional theme -->
    <link rel="stylesheet" href="{{ asset('/assets/css/bootstrap-theme.min.css') }}" tppabs="{{ asset('/assets/css/bootstrap-theme.min.css') }}">
    <!-- Latest compiled and minified JavaScript -->
    <script src="{{ asset('/assets/js/bootstrap.min.js') }}" tppabs="{{ asset('/assets/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('/assets/js/cleanair.js') }}" tppabs="{{ asset('/assets/js/cleanair.js') }}"></script>

    <link rel="stylesheet" media="all" href="{{ asset('/assets/css/cleanair.css') }}" tppabs="{{ asset('/assets/css/cleanair.css') }}" data-turbolinks-track="true" />






</head>
<body>
<div id="body" style="background: url(/assets/images/picture/{{ $companyData->picture }}) no-repeat center center; background-size: cover;">

    <div class="center" id="center">
        <div id="cust_logo_locs">
            <img src="/assets/images/logo/{{ $companyData->logo }}" alt="" style="width: auto; height: auto; max-height: 75px;max-width: 370px;"/>
        </div>
        @foreach($location as $loc)
            <div id="location_cont">
                <a href="{{url($jumpLocUrl.$loc->location_id)}}">
                    <div id="location_desc" style="background: url(/assets/images/{{ $loc->picture }}) no-repeat center center; background-size: cover;">
                        <div id="location_title">
                            <a href="{{url($jumpLocUrl.$loc->location_id)}}">{{ $loc->name_en }}</a><br>
                        </div>
                    </div>
                </a>
            </div>

        @endforeach


    </div>


    <div id="footer" >
        <img src="{{asset('/assets/images/cleanairspaceslogo.png')}}" style="width: auto; height: auto; max-height: 55px;max-width: 700px;">
    </div>
</div>

</body>
</html>
