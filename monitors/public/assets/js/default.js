



// Arc layout
$.circleProgress.defaults.arcCoef = 0.5; // range: 0..1
$.circleProgress.defaults.startAngle = 0.5 * Math.PI;

$.circleProgress.defaults.drawArc = function(v) {
    var ctx = this.ctx,
        r = this.radius,
        t = this.getThickness(),
        c = this.arcCoef,
        a = this.startAngle + (1 - c) * Math.PI;
    
    v = Math.max(0, Math.min(1, v));

    ctx.save();
    ctx.beginPath();

    if (!this.reverse) {
        ctx.arc(r, r, r - t / 2, a, a + 2 * c * Math.PI * v);
    } else {
        ctx.arc(r, r, r - t / 2, a + 2 * c * Math.PI, a + 2 * c * (1 - v) * Math.PI, a);
    }

    ctx.lineWidth = t;
    ctx.lineCap = this.lineCap;
    ctx.strokeStyle = this.arcFill;
    ctx.stroke();
    ctx.restore();
};

$.circleProgress.defaults.drawEmptyArc = function(v) {
    var ctx = this.ctx,
        r = this.radius,
        t = this.getThickness(),
        c = this.arcCoef,
        a = this.startAngle + (1 - c) * Math.PI;

    v = Math.max(0, Math.min(1, v));
    
    if (v < 1) {
        ctx.save();
        ctx.beginPath();

        if (v <= 0) {
            ctx.arc(r, r, r - t / 2, a, a + 2 * c * Math.PI);
        } else {
            if (!this.reverse) {
                ctx.arc(r, r, r - t / 2, a + 2 * c * Math.PI * v, a + 2 * c * Math.PI);
            } else {
                ctx.arc(r, r, r - t / 2, a, a + 2 * c * (1 - v) * Math.PI);
            }
        }

        ctx.lineWidth = t;
        ctx.strokeStyle = this.emptyFill;
        ctx.stroke();
        ctx.restore();
    }
};




FusionCharts.ready(function(){

    var refer_city=document.getElementById('refer_city').value;
    var refer_name_en=document.getElementById('refer_name_en').value;
    var reference_city=document.getElementById('reference_city').value;
    var jsonseries=document.getElementById('jsonseries').value;

    var jsoncol=document.getElementById('jsoncol').value;
    var jsonline=document.getElementById('jsonline').value;
    jsonseries=JSON.parse(jsonseries);
    jsoncol=JSON.parse(jsoncol);
    jsonline=JSON.parse(jsonline);
    //alert(jsonseries);
    //console.dir(JSON.parse(jsonseries));
      var revenueChart = new FusionCharts({
        "type": "scrollcombi2d",
        "renderAt": "chartContainer",
        "width": "100%",
        "height": "300",
        "dataFormat": "json",
        "dataSource": {
          "chart": {
			"caption": refer_city+'-'+refer_name_en,//refer_city-refer_name_en
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
           },
             "categories":jsonseries ,
            "dataset": [
                {"seriesName": refer_city+'-'+refer_name_en, "showValues": "1", "renderAs": "column","data": jsoncol},
                {"seriesName": reference_city,"renderAs": "spline","showValues": "0","data": jsonline }
            ]

        }
    });

    revenueChart.render();
})



 type="text/javascript">

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
    ///Refresh?company_id=1&location_id=1&monitor_id=1&parameter=0
        var company_id=document.getElementById('company_id').value;
        var location_id=document.getElementById('location_id').value;
        var monitor_id=document.getElementById('monitor_id').value;
        var parameter=document.getElementById('parameter').value;


    var ref = $.ajax({
        //url: "/temp.json"/*tpa=http://103.20.61.11/refresh_data.php/?c=1&l=1*/,?company_id=arr[1]&location_id=arr[2]&monitor_id=arr[3]&parameter=arr[4]
        url: "index.php/api/router",
        timeout: 60000,
        data:{'app_id':1,'method':'Refresh','nonce':'aa','company_id':company_id,'location_id':location_id,'monitor_id':monitor_id,'parameter':parameter},
        dataType:'json',
        success:function(data){
            var obj = data;
            ref_indoordata(obj.indoor.indoor_pm,obj.indoor.indoor_color, obj.indoor.indoor_color, obj.indoor.indoor_textcolor, obj.indoor.indoor_text,obj.indoor.indoor_level,obj.indoor.indoor_time,obj.indoor.indoor_voc,obj.indoor.indoor_co2,obj.indoor.param_label,obj.indoor.display_param);
            ref_outdoordata(obj.outdoor.outdoor_pm,obj.outdoor.outdoor_color, obj.outdoor.outdoor_color, obj.outdoor.outdoor_textcolor, obj.outdoor.outdoor_text,obj.outdoor.outdoor_level,obj.outdoor.outdoor_time, obj.outdoor.param_label,obj.outdoor.display_param);
        }
    })
    	.fail(function() {
    		//setInterval('refreshPage()', 30000);
    	})
    	.always(function() {
    		//setInterval('refreshPage()', 40000);
    	});
    }
    
    function ref_indoordata(aqvalue,aqcolor, btn_bgcolor, btn_color, btn_text, pm_level, time_indoor, tvoc_indoor, co2, param_label, display_param)
    {
		var aqival = display_param;
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

	    $('#indoor_hr_center').css('background-color',"#00ff00");
	    $('#indoor_middle_content').html("TVOC<br>"+ tvoc_indoor +" µg/m³");

	    $('#indoor_hr_left').css('background-color',btn_bgcolor);
	    $('#indoor_left_content').html("PM 2.5<br>"+aqvalue+" µg/m³");


	    $('#indoor_hr_right').css('background-color',"#00ff00");
	    $('#indoor_right_content').html("CO2<br>"+co2+" ppm");

	    $('#indoor_readings_time').html("Last updated on: "+ time_indoor);

	    $('#indoor_circle_param').html(param_label);

	    $('#indoor_circle_value').css('color',btn_bgcolor);
	    $('#indoor_circle_value').html(aqival);
	    
	    $('#indoor_btn').css('backgroundColor',btn_bgcolor);
        $('#indoor_btn').css('color',btn_color);
        $('#indoor_btn').html(btn_text);
    }

    function ref_outdoordata(aqvalue,aqcolor, btn_bgcolor, btn_color, btn_text,pm_level, time, param_label, display_param)
    {
		var aqival = display_param;
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

	    $('#outdoor_circle_param').html(param_label);


	    $('#outdoor_btn').css('backgroundColor',btn_bgcolor);
        $('#outdoor_btn').css('color',btn_color);
        $('#outdoor_btn').html(btn_text);
    }
    	


