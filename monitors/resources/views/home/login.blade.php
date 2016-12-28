<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>CleanAir Spaces Monitoring - Haworth</title>


</head>

<body>
<div >
    CLEANAIR Monitoring
</div>
<div  >

    Customer Name:<div id="search-form"></div>

    <div id="message"></div>
</div>

<div id="" class="">
    <form method="post" action="">
        <!--get all company name-en from companyAll_name   Array -->

        <input type="hidden" name="company_id" value="">

        <!--if in_array(company_id,companySecure_ids) ,need user and pwd,else gray-->
        User:<input type="user" name="user">
        Password:<input type="password" name="password">
    </form>
</div>

<input type="button" value="GO" onclick="location.href()">
<div >

    <img src="{{ asset('/assets/images/logo/cleanairtestlogo.png') }}" alt="">
</div>


<!--complete-->


<script type="text/javascript" src="{{ asset('/assets/autocomplete/jquery.js') }}"></script>
<script type="text/javascript" src="{{ asset('/assets/autocomplete/autocomplete.js') }}"></script>

<script type="text/javascript">
    var proposals = ['百度1', '百度2', '百度3', '百度4', '百度5', '百度6', '百度7','呵呵呵呵呵呵呵','百度','新浪','a1','a2','a3','a4','b1','b2','b3','b4'];

    $(document).ready(function(){
        $('#search-form').autocomplete({
            hints: proposals,
            width: 300,
            height: 30,
            onSubmit: function(text){
                $('#message').html('Selected: <b>' + text + '</b>');
            }
        });
    });
</script>
</body>
</html>