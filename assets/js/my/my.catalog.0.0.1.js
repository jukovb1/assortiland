jQuery(document).ready(function($) {
    $('.cat-categories').click(function() {
        if($('#catmenu').is(':visible')) {
            $('#catmenu').slideUp('slow');
            $('.cat-categories .hb-but').css('background-position', '0 -10px');
        } else {
            $('#catmenu').slideDown('slow');
            $('.cat-categories .hb-but').css('background-position', '0 0');
        }
    });
    $('.cat-search').click(function() {
        if($('#search-form').is(':visible')) {
            $('#search-form').slideUp('slow');
            $('.cat-search .hb-but').css('background-position', '0 -10px');
        } else {
            $('#search-form').slideDown('slow');
            $('.cat-search .hb-but').css('background-position', '0 0');
        }
    });
    $('.cat-price').click(function() {
        if($('#price-form').is(':visible')) {
            $('#price-form').slideUp('slow');
            $('.cat-price .hb-but').css('background-position', '0 -10px');
        } else {
            $('#price-form').slideDown('slow');
            $('.cat-price .hb-but').css('background-position', '0 0');
        }
    });
    $('.cat-offer').click(function() {
        if($('#offer-form').is(':visible')) {
            $('#offer-form').slideUp('slow');
            $('.cat-offer .hb-but').css('background-position', '0 -10px');
        } else {
            $('#offer-form').slideDown('slow');
            $('.cat-offer .hb-but').css('background-position', '0 0');
        }
    });
    $('.cat-popular').click(function() {
        if($('.popmenu').is(':visible')) {
            $('.popmenu').slideUp('slow');
            $('.cat-popular .hb-but').css('background-position', '0 -10px');
        } else {
            $('.popmenu').slideDown('slow');
            $('.cat-popular .hb-but').css('background-position', '0 0');
        }
    });

    // show on default block
	//$('.cat-search, .cat-price, .cat-offer, .cat-popular').click();

    var $slider = $('.price-range'),
        $lower = $('.lower_bound'),
        $upper = $('.upper_bound'),
        $price_reset = $('#price_reset'),
        min_rent = price['min'],
        max_rent = price['max'];


    if ($lower.val().length<=0){
        $lower.val(min_rent);
    }
    if ($upper.val().length<=0){
        $upper.val(max_rent);
    }

    $slider.slider({
        orientation: 'horizontal',
        range: true,
        animate: 200,
        min: min_rent,
        max: max_rent,
        step: 1,
        value: 0,
        values: [$lower.val(), $upper.val()],
        slide: function(event,ui) {
            $lower.val(ui.values[0]);
            $upper.val(ui.values[1]);
        }
    });

    $price_reset.click(function () {
        $lower.val(min_rent);
        $upper.val(max_rent);
        $slider.slider('values', 0, min_rent);
        $slider.slider('values', 1, max_rent);
        $('#price-form').submit();
    });

    $lower.keyup(function () {
        var low = $lower.val(),
            high = $upper.val();
        low = Math.min(low, high);
        $lower.val(low);
        $slider.slider('values', 0, low);
    });

    $upper.keyup(function () {
        var low = $lower.val(),
            high = $upper.val();
        high = Math.max(low, high);
        $upper.val(high);
        $slider.slider('values', 1, high);
    });
    
    // ==============
    // Вознаграждение
    // ==============
    if($('.offer-scroller').length > 0) {
	    var $slider_offer = $('.price-range-offer'),
	        $lower_offer = $('.lower_bound_offer'),
	        $upper_offer = $('.upper_bound_offer'),
	        $price_reset_offer = $('#offer_reset'),
	        min_rent_offer = price_offer['min'],
	        max_rent_offer = price_offer['max'];
	
	
	    if ($lower_offer.val().length<=0){
	        $lower_offer.val(min_rent_offer);
	    }
	    if ($upper_offer.val().length<=0){
	        $upper_offer.val(max_rent_offer);
	    }
	
	    $slider_offer.slider({
	        orientation: 'horizontal',
	        range: true,
	        animate: 200,
	        min: min_rent_offer,
	        max: max_rent_offer,
	        step: 0.5,
	        value: 0,
	        values: [$lower_offer.val(), $upper_offer.val()],
	        slide: function(event,ui) {
	            $lower_offer.val(ui.values[0]);
	            $upper_offer.val(ui.values[1]);
	        }
	    });
	
	    $price_reset_offer.click(function () {
	        $lower_offer.val(min_rent_offer);
	        $upper_offer.val(max_rent_offer);
	        $slider_offer.slider('values', 0, min_rent_offer);
	        $slider_offer.slider('values', 1, max_rent_offer);
	        $('#offer-form').submit();
	    });
	
	    $lower_offer.keyup(function () {
	        var low = $lower_offer.val(),
	            high = $upper_offer.val();
	        low = Math.min(low, high);
	        $lower_offer.val(low);
	        $slider_offer.slider('values', 0, low);
	    });
	
	    $upper_offer.keyup(function () {
	        var low = $lower_offer.val(),
	            high = $upper_offer.val();
	        high = Math.max(low, high);
	        $upper_offer.val(high);
	        $slider_offer.slider('values', 1, high);
	    });
	}
    
    // slider for sub category products
	// sub category products slide arrows
	$('.subcatmenu-slider-left-arrow').click(function() {
		var carousel = $(this).parent().find('.jcarousel');
		carousel.jcarousel('scroll', '+=3');
	});
	$('.subcatmenu-slider-right-arrow').click(function() {
		var carousel = $(this).parent().find('.jcarousel');
		carousel.jcarousel('scroll', '-=3');
	});
	$('.jcarousel').each(function() {
		$(this).jcarousel({
	        vertical	: true
	    });
	});
	
	$(".like").on("click", function() {
        var _this = $(this);
        var sub_area_art = $(this).find('a').data('article');
        $.post(
            "/index.ajax.php",
            {
                area        : 'product',
                sub_area    : sub_area_art,
                action      : 'add_dignity'
            },
            function(json){
                if(json['result']!=false) {
                    _this.find('span').html(json['result_data']);
                } else {
                    show_popup();
                    $(result_ajax).html(nl2br(json['result_msg']));
                    $(result_ajax).addClass('msg_err');
                    hide_popup(2000);
                }
            },
            'json'
        );
	});
    $(".del_from_partner_cat").on("click", function() {
        var product_article =  $(this).data('product_article');

        $.post(
            "/index.ajax.php",
            {
                area        : 'product',
                sub_area    : product_article,
                action      : 'del_from_partner'
            },
            function(json){
                show_popup();
                $(result_ajax).html(nl2br(json['result_msg']));
                if(json['result']!=false) {
                    $('.product_'+product_article).remove();
                    $(result_ajax).addClass('msg_ok');
                    hide_popup(2000);
                } else {
                    $(result_ajax).addClass('msg_err');
                    hide_popup(5000);
                }
            },
            'json'
        );
    });
});