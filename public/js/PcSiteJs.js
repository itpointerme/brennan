$(function(){
	$('.language span').click(function(){
		$(this).parent().find('ul').slideToggle()
	})
	jQuery(".fullSlide").slide({mainCell:".bd ul",  autoPlay:true, autoPage:true, trigger:"mouseover" });
	jQuery(".picScroll-left").slide({mainCell:".bd ul",autoPage:true,effect:"leftLoop",autoPlay:true,vis:7,trigger:"click"});
	jQuery(".picScroll-left-wap").slide({mainCell:".bd ul",autoPage:true,effect:"leftLoop",autoPlay:true,vis:3,trigger:"click"});
	window._bd_share_config={"common":{"bdSnsKey":{},"bdText":"","bdMini":"2","bdMiniList":false,"bdPic":"","bdStyle":"1","bdSize":"32"},"share":{}};with(document)0[(getElementsByTagName('head')[0]||body).appendChild(createElement('script')).src='http://bdimg.share.baidu.com/static/api/js/share.js?v=89860593.js?cdnversion='+~(-new Date()/36e5)];
})
$(window).load(function () {
	  $(".mobile-inner-header-icon").click(function(){
			if($('.mobile-inner-nav').is(":hidden")){
				$('.sp1').css('display','none');
				$('body').css('overflow','hidden');
			}else{				
				$('.sp1').css('display','block');
				$('body').css('overflow','auto');
			}
			$(this).toggleClass("mobile-inner-header-icon-click mobile-inner-header-icon-out");
			
			
			$(".mobile-inner-nav").slideToggle(250);
	  });
	  $(".mobile-inner-nav a").each(function( index ) {
		$( this ).css({'animation-delay': (index/10)+'s'});
	  });
});
