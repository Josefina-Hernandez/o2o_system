$(window).on('load resize', function(){
	var wid = window.innerWidth || document.documentElement.clientWidth || document.body.clientWidth;
	if( wid <= 767 ){ //SP‚Ì‚Ý
	 	$(".refineSec h2").click(function(){
			if($(this).hasClass("open")){
				$(".cityListWrap:not(:animated)").slideUp(300);
				$(this).removeClass("open");
			}else{
				$(".cityListWrap:not(:animated)").slideDown(300);
				$(this).addClass("open");
			}
		});
	}else{ //PC‚Ì‚Ý
		
	}
});