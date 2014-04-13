jQuery(document).ready(function($) {
	// main slide
	// main slide arrows
    $('.slider-left-arrow').click(function() {
		$('#slider').data('AnythingSlider').goBack();
	});
	$('.slider-right-arrow').click(function() {
		$('#slider').data('AnythingSlider').goForward();
	});
	$('#slider').anythingSlider({
		autoPlay            : true,
		infiniteSlides		: false, // cloning
		startStopped        : false,
		resizeContents      : true,
		buildNavigation     : false,
		buildStartStop      : false,
		buildArrows         : false,
		hashTags			: false,
		delay               : 5000,
		animationTime       : 700
	});
	
	// slider for quotes
	$('#quote-slider').anythingSlider({
		autoPlay            : true,
		infiniteSlides		: false, // cloning
		startStopped        : false,
		resizeContents      : true,
		buildNavigation     : true,
		buildStartStop      : false,
		buildArrows         : false,
		hashTags			: false,
		delay               : 3000,
		animationTime       : 700
	});
	
	// slider for sub category products
	// sub category products slide arrows
	$('.partners-slider-left-arrow').click(function() {
		var carousel = $(this).parent().find('.partners-slider');
		carousel.jcarousel('scroll', '-=1');
	});
	$('.partners-slider-right-arrow').click(function() {
		var carousel = $(this).parent().find('.partners-slider');
		carousel.jcarousel('scroll', '+=1');
	});
	$('.partners-slider').each(function() {
		$(this).jcarousel();
	});
});