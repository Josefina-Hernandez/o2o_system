$(function(){
	// SPメニュー
	$(".menuBtn").click(function(){
		if($("#glonav").hasClass("open")){
			$("#glonav").slideUp(300);
			$("#glonav").removeClass("open");
		}else{
			$("#glonav").slideDown(300);
			$("#glonav").addClass("open");
		}
	});
	
	// グロナビカレント表示
	var pathname = location.pathname;
	var glonavList = $("#glonav > ul > li");
	pathname = pathname.replace(/(page\/.+\/).+/ , "$1index");
	console.log(pathname);
	glonavList.find("p a[href='"+pathname+"']").parents("li").addClass("_cur");
	
	//店舗ページヘッダー固定
	if($(".shopHead").length){
		var nav = $('.shopHead');
		var header = $('body > header');
		offset = nav.offset().top;

		navH = nav.height();
		headerH = header.height();
		offset = navH + headerH + 40;
		
		$(window).scroll(function () {
			if($(window).scrollTop() > offset) {
				$("body").addClass('fixed');
				$("#mainArea article").css("paddingTop", navH + 40 + "px");
			} else {
				$("body").removeClass('fixed');
				$("#mainArea article").css("paddingTop", 0);
			}
		});
	}
});

$(window).on('load resize', function(){
	var wid = window.innerWidth || document.documentElement.clientWidth || document.body.clientWidth;
	if( wid <= 767 ){ //SPのみ
		$(".shopmodal").colorbox({
			iframe:true,
			height:"60%",
			width:"90%"
		});
		$(".youtube").colorbox({
			iframe:true,
			innerWidth:640,
			maxWidth:"95%",
			innerHeight:390,
			maxHeight:"50%"
		});
	}else{ //PCのみ
		$(".downList").hover(function(){
			$(this).find(".slidedown:not(:animated)").slideDown(300);
		},function(){
			$(this).find(".slidedown:not(:animated)").slideUp(300);
		});
		$(".shopmodal").colorbox({
			iframe:true,
			height:"85%",
			maxHeight:"730px",
			width:"95%",
			maxWidth:"940px"
		});
		$(".youtube").colorbox({
			iframe:true,
			innerWidth:640,
			innerHeight:390
		});
	}
});