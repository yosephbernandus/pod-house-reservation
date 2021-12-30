new WOW().init();

$(function(){
	$('.portfolio-item a').Chocolat();
	$('.special-grid a').Chocolat();

	size_li = $("#myList li").size();
	x=1;
	$('#myList li:lt('+x+')').show();
	$('#loadMore').click(function () {
		x= (x+1 <= size_li) ? x+1 : size_li;
		$('#myList li:lt('+x+')').show();
	});
	$('#showLess').click(function () {
		x=(x-1<0) ? 1 : x-1;
		$('#myList li').not(':lt('+x+')').hide();
	});

	$("#slider1, #slider2, #slider3, #slider4").responsiveSlides({
		auto: true,
		nav: true,
		speed: 1500,
		namespace: "callbacks",
		pager: true,
	});

	$('.popup-with-zoom-anim').magnificPopup({
		type: 'inline',
		fixedContentPos: false,
		fixedBgPos: true,
		overflowY: 'auto',
		closeBtnInside: true,
		preloader: false,
		midClick: true,
		removalDelay: 300,
		mainClass: 'my-mfp-zoom-in'
	});

	var defaults = {
        containerID: 'toTop', // fading element id
        containerHoverID: 'toTopHover', // fading element hover id
        scrollSpeed: 100,
        easingType: 'linear'
    };
    $().UItoTop({ easingType: 'easeOutQuart' });

    $(".scroll, .navbar li a, .footer li a").click(function(event){
    	$('html,body').animate({scrollTop:$(this.hash).offset().top},1000);
    });

    $('#rating').barrating({
    	theme: 'fontawesome-stars'
    });

    $( "#datepicker,#datepicker1,#datepicker2" ).datepicker({ dateFormat: 'yy-mm-dd'});

    $('.gallery a').lightbox();

    $('.testimonials-container').backstretch("assets/img/backgrounds/1.jpg");
                
    $('a[data-toggle="tab"]').on('shown.bs.tab', function(){
        $('.testimonials-container').backstretch("resize");
    });
})