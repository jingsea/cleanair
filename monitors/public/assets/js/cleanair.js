// When ready...
/*
window.addEventListener("load",function() {
	// Set a timeout...
	setTimeout(function(){
		// Hide the address bar!
		window.scrollTo(0, 1);
	}, 0);
});
*/

$('.btn-toggle').click(function() {
    $(this).find('.btn').toggleClass('active');  
    
    if ($(this).find('.btn-primary').size()>0) {
    	$(this).find('.btn').toggleClass('btn-primary');
    }
    if ($(this).find('.btn-danger').size()>0) {
    	$(this).find('.btn').toggleClass('btn-danger');
    }
    if ($(this).find('.btn-success').size()>0) {
    	$(this).find('.btn').toggleClass('btn-success');
    }
    if ($(this).find('.btn-info').size()>0) {
    	$(this).find('.btn').toggleClass('btn-info');
    }
    
    $(this).find('.btn').toggleClass('btn-default');
       
});


$('form').submit(function(){
	alert($(this["options"]).val());
    return false;
});

    $(".btn_hidechart").click(function(){
        $(".chart_panel").hide();
    });
    $(".btn_showchart").click(function(){
        $(".chart_panel").show();
    });

	$('.js-btn-reading-graph-show').click(function () {
		$('.show-page__container-with-background-overlay').show();
		reload_graph();
	});
	
	$('.js-btn-reading-graph-hide').click(function () {
		$('.show-page__container-with-background-overlay').hide();
	});
	


// FusionCharts.ready(function(){
//       var revenueChart = new FusionCharts({
//         "type": "spline",
//         "renderAt": "chartContainer",
//         "width": "100%",
//         "height": "300",
//         "dataFormat": "json",
//         "dataSource": {
//           "chart": {
//               "caption": "Monitor Name",
//               "subCaption": "PM2.5 Last 24 Hours",
//               "xAxisName": "Hour",
//               "yAxisName": "PM 2.5",
//               "theme": "fint"
//            },
//           "data": [{"label": "2016-02-13 13:00:00", "value": "-1"},{"label": "2016-02-13 14:00:00", "value": "-1"},{"label": "2016-02-13 15:00:00", "value": "-1"},{"label": "2016-02-13 16:00:00", "value": "-1"},{"label": "2016-02-13 17:00:00", "value": "-1"},{"label": "2016-02-13 18:00:00", "value": "-1"},{"label": "2016-02-13 19:00:00", "value": "-1"},{"label": "2016-02-13 20:00:00", "value": "-1"},{"label": "2016-02-13 21:00:00", "value": "-1"},{"label": "2016-02-13 22:00:00", "value": "-1"},{"label": "2016-02-13 23:00:00", "value": "29.25"},{"label": "2016-02-14 00:00:00", "value": "30.5"},{"label": "2016-02-14 01:00:00", "value": "35.33330154418945"},{"label": "2016-02-14 02:00:00", "value": "34.5"},{"label": "2016-02-14 03:00:00", "value": "34.75"},{"label": "2016-02-14 04:00:00", "value": "31.25"},{"label": "2016-02-14 05:00:00", "value": "29"},{"label": "2016-02-14 06:00:00", "value": "25.5"},{"label": "2016-02-14 07:00:00", "value": "27.75"},{"label": "2016-02-14 08:00:00", "value": "31"},{"label": "2016-02-14 09:00:00", "value": "25.5"},{"label": "2016-02-14 10:00:00", "value": "25.5"},{"label": "2016-02-14 11:00:00", "value": "16.75"}] 
//         }
//     });
// 
//     revenueChart.render();
// })


