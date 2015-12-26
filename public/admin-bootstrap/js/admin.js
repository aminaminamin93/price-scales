$(document).ready(function(){
	var d = new Date();

	var month = d.getMonth()+1;
	var day = d.getDate();
	var year = d.getFullYear();
	var output = d.getFullYear() + '-' + (month<10 ? '0' : '') + month + '-' + (day<10 ? '0' : '') + day;
	function addLeadingZero(num) {
	    if (num < 10) {
	      return "0" + num;
	    } else {
	      return "" + num;
	    }
	  }


	$('.sidebar-menu > li').click(function(){
	  $(this).addClass('testing');
	});

	$("#myTab li:eq(0) a").tab('show');
	$fullDate = year+'-'+month+'-'+day;

	$(".responsive-calendar").responsiveCalendar({

      	
	});
});
// {
		
// 	      time: $fullDate,
// 	      current: $fullDate,
// 	      events: {
// 	        "2013-04-30": {"number": 5, "url": "http://w3widgets.com/responsive-slider"},
// 	        "2013-04-26": {"number": 1, "url": "http://w3widgets.com"}, 
// 	        $fullDate:{"number": 1}, 
// 	        $fullDate: {}},
// 	}