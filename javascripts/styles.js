jQuery(document).ready(function($){
	$(".vertical-align").each(function(){
		var thisHeight = $(this).height(); 
		$(this).css({
			"margin": (180 - thisHeight) / 2 + 'px auto'
		});
	});
	$(window).load(function(){
		$(".vertical-align").each(function(){
			var thisHeight = $(this).height(); 
			$(this).css({
				"margin": (180 - thisHeight) / 2 + 'px auto'
			});
		});
	});
});