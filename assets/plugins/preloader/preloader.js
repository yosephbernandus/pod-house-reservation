function nyandaBisaKlik(a) {
	$(a).click(function(e) {
	    e.stopPropagation();
	    e.preventDefault();
	    e.stopImmediatePropagation();

	    return false;
	});

	$(a).bind('contextmenu', function(e) {
	    e.stopPropagation();
	    e.preventDefault();
	    e.stopImmediatePropagation();
	    return false;
	});
}

function bisaKlik(a) {
	$(a).unbind('click');
	$(a).unbind('contextmenu');
}

function preloader(action) {
	
	if(action == 'show') {
		
		$('#statusLoading').show();
		$('#preloader').show();
		$('html,body').css({
			'overflow': 'hidden'
		});
		nyandaBisaKlik('#preloader');
	}
	else if(action == 'hide') {
		$('#statusLoading').hide();
		$('#preloader').hide();
		$('html,body').css({
			'overflow': 'visible'
		});
		bisaKlik('#preloader');
	}
}

$(window).on('load', function() {
	preloader('hide');
});

$(document).ready(function(){
	nyandaBisaKlik('#preloader');
	$(document).on('click', 'a[href]:not([href^="#"]):not(.example-image-link)', function(e){
		preloader('show');
	});
});