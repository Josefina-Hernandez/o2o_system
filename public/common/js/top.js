$(window).on('load resize', function(){
	var wid = window.innerWidth || document.documentElement.clientWidth || document.body.clientWidth;
	if( wid <= 767 ){ //SP‚Ì‚Ý
	 	$(".campBnr").owlCarousel({
			autoplay: false,
			autoplayTimeout: 5000,
			autoplaySpeed: 1000,
			items: 2,
			loop: false,
			mouseDrag: true,
			nav:true,
			navText:["",""]
		});
	 	$(".studyList").owlCarousel({
			autoplay: false,
			autoplayTimeout: 5000,
			autoplaySpeed: 1000,
			items: 1,
			loop: false,
			mouseDrag: true,
			nav:true,
			navText:["",""]
		});
	}else{ //PC‚Ì‚Ý
		
	}
});