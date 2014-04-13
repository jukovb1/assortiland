jQuery(document).ready(function($) {
	// hide on default block
	$('.full-descr').hide();

	$('.helpful .title').click(function() {
		if($('.full-descr').is(':visible')) {
			$('.full-descr').slideUp('slow');
			$('.h-button').css('background-position', '0 32px');
		} else {
			$('.full-descr').slideDown('slow');
			$('.h-button').css('background-position', '32px 0');
		}
	});
});