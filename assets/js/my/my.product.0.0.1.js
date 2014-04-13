jQuery(document).ready(function($) {
	
	// ========= TABS =========
	// custom tabs
	var tab_classes 		= [".product-tab"];
	var tab_desc_classes 	= [".tabs-block"];
	
	for (index = 0; index < tab_classes.length; ++index)
		inactivate_tabs(tab_classes[index], tab_desc_classes[index]);

	// actions
	$('.product-tab li').click(function(e) {
		e.preventDefault();
		$('.product-tab li a').removeClass('tab-selected');
		$(this).find('a').addClass('tab-selected');
		
		show_tab_content('.product-tab', $(this), '.tabs-block');
	});
	
	
	// funtion for custom tabs work
	// * tab_class_name - for the current tab class name
	// * tab_class_this - for $(this)
	// * tab_desc_class - for tab descrition class name
	//
	function show_tab_content(tab_class_name, tab_class_this, tab_desc_class) {
		var t = tab_class_this.find('a').attr('id');
		
		// if tab is inactive
		if(tab_class_this.hasClass('inactive')) { //this is the start of our condition 
			
			// add class 'inactive' to all tabs
			$(tab_class_name + ' li').addClass('inactive');           
			// but remove class from current tab
			tab_class_this.removeClass('inactive');

			// hide tabs with description class
			$(tab_desc_class).hide();
			// but show the specific tab description
			$('#'+ t + '-c').show();
		}
	}
	
	// function for hiding of all the tabs except ':first'
	// * tab_class - for $(this)
	// * tab_desc_class - for tab descrition class name
	//
	function inactivate_tabs(tab_class, tab_desc_class) {
		$(tab_class + ' li:not(:first)').addClass('inactive');
		$(tab_desc_class).hide();
		$(tab_desc_class+':first').show();
	}
	
	$(".p-like").on("click", function() {
		var _this = $(this);
        var sub_area_art = $('.p-like-img').data('article');
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
	
	$(".add_to_cart").on("click", function() {
		if (typeof sub_area == 'undefined'){
	        sub_area = $('.product-buy').data('product-article');
	    }
		$.post(
	        "/index.ajax.php",
	        {
	            area        : 'product',
	            sub_area    : sub_area,
	            action      : 'add_to_cart'
	        },
	        function(json){
                show_popup();
                $(result_ajax).html(nl2br(json['result_msg']));
                if(json['result']!=false) {
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
	$(".add_to_partner").on("click", function() {
        var that =  $(this);
		if (typeof sub_area == 'undefined'){
	        sub_area = $('.product-buy').data('product-article');
	    }

		$.post(
	        "/index.ajax.php",
	        {
	            area        : 'product',
	            sub_area    : sub_area,
	            action      : 'add_to_partner'
	        },
	        function(json){
                show_popup();
                $(result_ajax).html(nl2br(json['result_msg']));
                if(json['result']!=false) {
                    that.remove();
                    $('.isset_block').show();
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