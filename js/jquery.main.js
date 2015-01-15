(function($) {
	$(function(){
		$('.logos-holder').flexslider({
			selector: '.logos-list > li',
			animation: 'slide',
			animationLoop: false,
			itemWidth: 133,
			itemMargin: 0,
			slideshowSpeed: 10000,
			animationSpeed: 1500,
			controlNav: false
		});
	});
})(jQuery);