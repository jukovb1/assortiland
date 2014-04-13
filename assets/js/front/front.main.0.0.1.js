var cur_sales_area = 'act';
$(document).ready(function($) {
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


    $('.change_sales_area').click(function(){
        var sales_area = $(this).data('sales_area');
        if (sales_area != cur_sales_area){
            $('.actions_block').hide();
            $('#'+sales_area+'_products').show();
            cur_sales_area = sales_area;
        }
        return false;
    });
});