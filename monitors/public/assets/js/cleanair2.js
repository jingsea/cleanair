

    $(document).ready(function() {
        // SET AUTOMATIC PAGE RELOAD TIME TO 5000 MILISECONDS (5 SECONDS).
        setInterval('refreshPage()', 900000);
        
        var aqival = 0;
        var aqiperc = aqival / 500;
                
        // Set values for charts
        $('#indoor_circle').circleProgress({
        value: aqiperc,
        size: 300,
        arcCoef: 0.7,
        fill: {
            color: "#ff1e41"
        },
        lineCap : "round",
        thickness: 10
    })

        
        // Set values for charts
        $('#outdoor_circle').circleProgress({
        value: aqiperc,
        size: 300,
        arcCoef: 0.7,
        fill: {
            color: "#ff1e41"
        },
        lineCap : "round",
        thickness: 10
    })


		refreshPage();

    });

    function refreshPage() {
    
    var ref = $.ajax({
		  type: "GET",
		  url: "'.$rest.'",
		  timeout: 60000
		  })
    	.done(function( data) {
    		var obj = jQuery.parseJSON( data );
    		ref_indoordata(obj.indoor.indoor_pm,obj.indoor.indoor_color, obj.indoor.indoor_color, obj.indoor.indoor_textcolor, obj.indoor.indoor_text,obj.indoor.indoor_level,obj.indoor.indoor_time);
    		ref_outdoordata(obj.outdoor.outdoor_pm,obj.outdoor.outdoor_color, obj.outdoor.outdoor_color, obj.outdoor.outdoor_textcolor, obj.outdoor.outdoor_text,obj.outdoor.outdoor_level,obj.outdoor.outdoor_time);
    	})
    	.fail(function() {
    		//setInterval('refreshPage()', 30000);
    	})
    	.always(function() {
    		//setInterval('refreshPage()', 40000);
    	});
    }
    
    function ref_indoordata(aqvalue,aqcolor, btn_bgcolor, btn_color, btn_text, pm_level, time)
    {
		var aqival = aqvalue;
		var percval = pm_level/6;
	        
        // Set values for charts
        $('#indoor_circle').circleProgress({
			value: percval,
			size: 300,
			arcCoef: 0.7,
			fill: {
				color: aqcolor
			},
			lineCap : "round",
			thickness: 10
	    });

	    $('#indoor_hr_left').css('background-color',btn_bgcolor);
	    $('#indoor_left_content').html("PM 2.5<br>"+aqival+" µg/m³");

	    $('#indoor_hr_center').css('background-color',"#00ff00");

	    $('#indoor_hr_right').css('background-color',"#00ff00");

	    $('#indoor_readings_time').html("Last updated on: "+time);



	    $('#indoor_circle_value').css('color',btn_bgcolor);
	    $('#indoor_circle_value').html(aqival);
	    
	    $('#indoor_btn').css('backgroundColor',btn_bgcolor);
        $('#indoor_btn').css('color',btn_color);
        $('#indoor_btn').html(btn_text);
    }

    function ref_outdoordata(aqvalue,aqcolor, btn_bgcolor, btn_color, btn_text,pm_level, time)
    {
		var aqival = aqvalue;
		var percval = pm_level/6;
	        
        // Set values for charts
        $('#outdoor_circle').circleProgress({
			value: percval,
			size: 300,
			arcCoef: 0.7,
			fill: {
				color: aqcolor
			},
			lineCap : "round",
			thickness: 10
	    });
	    
	    $('#outdoor_circle_value').css('color',btn_bgcolor);
	    $('#outdoor_circle_value').html(aqival);
	    
		$('#outdoor_readings_time').html("Last updated on: "+time);


	    $('#outdoor_btn').css('backgroundColor',btn_bgcolor);
        $('#outdoor_btn').css('color',btn_color);
        $('#outdoor_btn').html(btn_text);
    }
    	

