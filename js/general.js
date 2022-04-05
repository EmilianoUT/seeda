$(document).ready(function(){
	var urlPath = window.location.pathname,
    urlPathArray = urlPath.split('.'),
    tabId = urlPathArray[0].split('/').pop();
	$('#sales_people, #tasks, #project, #leads, #opportunity, #customer_win').removeClass('active');	
	$('#'+tabId).addClass('active');


	$('div[id^="expand"]').click(function(){
		$(this).next().show();
	})

	


});