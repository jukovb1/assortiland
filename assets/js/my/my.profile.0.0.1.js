function change_delivery_info_title(that) {
    if (typeof that == 'undefined'){
        that = false;
    }
    if ($("#order_cart").length) {
        $("#user_address").hide().prev("label").hide();
    }
    if (that != false) {
        var is_key = $(that).data('key');
        var delivery_label = $(that).find('option:selected').data('delivery_label');
        delivery_label = '<span style="color:#e65400">*</span> '+delivery_label;
        var label = $("#label_delivery_info_"+is_key);
        label.html(delivery_label);
        var textarea_id = label.attr('for');
        var textarea_val = $('#user_address').val();
        if ($(that).find('option:selected').data('delivery_id') == 3) {
            textarea_val = '';
        }
        $('#'+textarea_id).val(textarea_val);
    }
}
function remove_button() {
    var total_cost = $('.total_cost').find('.price_total');
    if (parseInt(total_cost.html()) == 0) {
        $('button[name="order"]').remove();
    }
}

/*function change_global_percents(){
    var price = parseFloat($('#pr_edit_param_5').val());
    if (price<1000){
        var percent = global_percents[0];
    } else if (price>=1000 && price<5000){
        percent = global_percents[1];
    } else {
        percent = global_percents[2];
    }
    var percent_val = $('#pr_edit_param_11');
    percent_val.attr('min',percent);
    if (percent_val.val()<percent){
        percent_val.val(percent);
    }
}*/

function checkbox_public_offer_status(checkbox) {
    if($(checkbox).attr('checked')) {
        $(checkbox).val('1');
        $('.reg-button').prop('disabled', false);
    } else {
        $(checkbox).val('0');
        $('.reg-button').prop('disabled', true);
    }
    $('.reg-button').toggleClass('button');
    $('.reg-button').toggleClass('button-disabled');
}

function check_validattion(that,is_each){
    if (typeof is_each == 'undefined'){
        is_each = false;
    }
    var info = $(that).attr('title');
    var pattern = $(that).attr('pattern');
    var val = $(that).val();
    pattern = new RegExp( "^"+pattern+"$", "ig");
    if (pattern.test(val)===true){
        if (is_each) return false;
        else submit_stop = false;

    } else {
        $(that).focus().nextAll('.show_dop_text').first().slideDown();
        $(that).focus().parent().next('.show_dop_text').slideDown();
        var destination = $(that).offset().top-50;
        $('body').animate({ scrollTop: destination }, 1100); //1100 - скорость
        setTimeout(function(){
            $('.show_dop_text').slideUp();
        },5000);
        if (is_each) return true;
        else submit_stop = true;
    }
}

jQuery(document).ready(function($) {
	$("#reg_public_offer_check").change(function(e){
		checkbox_public_offer_status($(this));
	});
	
	$('.reg-public-offer').click(function() {
		$.post(
	        "/index.ajax.php",
	        {
	            area        : 'profile',
	            sub_area    : 'public_offer',
	            action      : 'get_public_offer'
	        },
	        function(json){
	        	if(json['result']!=false) {
                    show_popup();
                    $(result_ajax).addClass('to_scroll').css('text-align','left').html(nl2br(json['result_msg']));
                }
	        },
	        'json'
        );
	});
	
	if($('#pr_edit_param_5').length>0 && $('#pr_edit_param_4').length>0) {
		$action_price = $('#pr_edit_param_4');
		$general_price = $('#pr_edit_param_5');
		$general_price.attr('type','text');
		$action_price.attr('type','text');
		
		// only NUMBERS allowed
		$('#pr_edit_param_4, #pr_edit_param_5').keydown(function(event) {
			// Allow: backspace, delete, tab, escape, enter without dot(190)
			if ( $.inArray(event.keyCode,[46,8,9,27,13]) !== -1 ||
				// Allow: Ctrl+A
				(event.keyCode == 65 && event.ctrlKey === true) || 
				// Allow: home, end, left, right
				(event.keyCode >= 35 && event.keyCode <= 39) || (event.keyCode == 0)) { // let it happen, don't do anything
					return;
			} else { // Ensure that it is a number and stop the keypress
				if (event.shiftKey || (event.keyCode < 48 || event.keyCode > 57) && (event.keyCode < 96 || event.keyCode > 105 ))
					event.preventDefault(); 
			}
		});
	}
	
	if($('#user_bank_code').length>0 && $('#user_bank_rated_number').length>0){
		$bank_code_input = $('#user_bank_code');
		$bank_rated_number = $('#user_bank_rated_number');
		$bank_code_input.attr('type','text');
		$bank_rated_number.attr('type','text');
		
		// only NUMBERS allowed
		$('#user_bank_code, #user_bank_rated_number').keydown(function(event) {
			// Allow: backspace, delete, tab, escape, enter without dot(190)
			if ( $.inArray(event.keyCode,[46,8,9,27,13]) !== -1 ||
				// Allow: Ctrl+A
				(event.keyCode == 65 && event.ctrlKey === true) || 
				// Allow: home, end, left, right
				(event.keyCode >= 35 && event.keyCode <= 39) || (event.keyCode == 0)) { // let it happen, don't do anything
					return;
			} else { // Ensure that it is a number and stop the keypress
				if (event.shiftKey || (event.keyCode < 48 || event.keyCode > 57) && (event.keyCode < 96 || event.keyCode > 105 ))
					event.preventDefault(); 
			}
		});
	}
	
	$('.sbscrb-button').click(function() {
        var button = $(this);
		var text = button.html();
		var alt_text = button.data('alt_text');
		$.post(
	        "/index.ajax.php",
	        {
	            area        : 'profile',
	            sub_area    : 'change_subscribe_status',
	            action    : 'change_subscribe_status'
	        },
	        function(json){
                show_popup();
                $(result_ajax).html(nl2br(json['result_msg']));
                if(json['result']!=false) {
                    $(result_ajax).addClass('msg_ok');
                    hide_popup(2000);
                    button.data('alt_text',text).html(alt_text);
                    $('p.subscribe').toggle();
                } else {
                    $(result_ajax).addClass('msg_err');
                    hide_popup(5000);
                }
	        },
	        'json'
        );
	});

    $("#pr_edit_param_9").change(function(e){
        if(!e.srcElement) return;
        var file_size = (e['srcElement']['files']['0']['size'])/1000; // размер файла в кБ, не работает в IE 9 и меньше
        if (file_size>500){
            $(this).val('').next('.msg_err').show();
        } else {
            $(this).next('.msg_err').hide();
        }
    });

    /*change_global_percents();
    $('#pr_edit_param_11').blur(function() {
        change_global_percents();
    });*/
    $('#pr_edit_param_13, #pr_edit_param_14').attr({type:'date',class:'drv-lines-date'});

    remove_button();
    change_delivery_info_title();

    $('.button_link').click(function() {
        var href = $(this).data('href');
        location.href = $(this).data('href');
    });

    $(".redactor").each(function(){
        var lang_abbr = $('body').data('lang_abbr');
        $(this).redactor({lang: lang_abbr, toolbar: 'mini'});
    });

    $('button:submit').click(function(){
        submit_stop_r = false;
        $('input[pattern]').each(function(){
            if (typeof $(this).attr('required')=='undefined'){
                if ($(this).val().length>0){
                    submit_stop_r = check_validattion(this,1);
                }
            } else {
                submit_stop_r = check_validattion(this,1);
            }
            if (submit_stop_r==true) return false;
        });
        if (submit_stop_r==false){
            $('input[required],textarea[required]').each(function(){
                if (submit_stop==false && (empty($(this).val())==true || $(this).val()==" ")){
                    var lang_id = $(this).parent().data('lang_id');
                    if (typeof lang_id != 'undefined'){
                        show_lang_tabs($('#lang_tab_'+lang_id),lang_id);
                    }
                    var destination = $(this).offset().top-50;
                    if($(this).is(":hidden")==true){
                        destination = $(this).prev('iframe').offset().top-50;
                    }
                    $('body').animate({ scrollTop: destination }, 1100); //1100 - скорость
                    if($(this).is(":hidden")==true){
                        $(this).prev('iframe').child('body').focus();
                        $(this).parent().next('.show_required_text').slideDown();
                    } else {
                        $(this).focus().next('.show_required_text').slideDown();
                    }
                    setTimeout(function(){
                        $('.show_required_text').slideUp();
                    },5000);
                    submit_stop_r = true;
                    return false;

                }

            });
        }
        if (submit_stop_r==false){
            $('select[required]').each(function(){
                console.log(this);
                if (submit_stop==false && (empty($(this).val())==true || $(this).val()=="0")){
                    var lang_id = $(this).parent().data('lang_id');
                    var destination = $(this).offset().top-50;
                    if ($(this).attr('class') == 'sf_cbx'){
                        destination = $('.for_multi_select').offset().top-50;
                        $('body').animate({ scrollTop: destination }, 1100); //1100 - скорость
                        $('.for_multi_select').next('.show_required_text').slideDown();
                    } else {
                        $('body').animate({ scrollTop: destination }, 1100); //1100 - скорость
                        $(this).focus().next('.show_required_text').slideDown();
                    }
                    setTimeout(function(){
                        $('.show_required_text').slideUp();
                    },5000);
                    submit_stop_r = true;
                }
            });
        }
        if (submit_stop == true || submit_stop_r == true){
            return false;
        }
    });
    
    // =======================================
	// Переключатель цены для корзины
	// =======================================
	
	// only NUMBERS allowed
	$('.prod-fullqty .numbertype').keydown(function(event) {
		// Allow: backspace, delete, tab, escape, enter without dot(190)
		if ( $.inArray(event.keyCode,[46,8,9,27,13]) !== -1 ||
			// Allow: Ctrl+A
			(event.keyCode == 65 && event.ctrlKey === true) || 
			// Allow: home, end, left, right
			(event.keyCode >= 35 && event.keyCode <= 39) || (event.keyCode == 0)) { // let it happen, don't do anything
				return;
		} else { // Ensure that it is a number and stop the keypress
			if (event.shiftKey || (event.keyCode < 48 || event.keyCode > 57) && (event.keyCode < 96 || event.keyCode > 105 ))
				event.preventDefault(); 
		}
	});

	
	// click the 'plus' & 'minus'
	$('.plus,.minus').click(function(e) {
        var product_article = $(this).parents('.prod-in-cart').data('product-article');
        var parent_block = $(".prod-in-cart[data-product-article='"+product_article+"']");
        var price_input = parent_block.find('.price_one');
        var price_total_input = parent_block.find('.price_all');
		var count_input = $(this).prevAll('.numbertype');
		var count = parseInt(count_input.val());
        var total_cost = $('.total_cost').find('.price_total');
        if ($(this).attr('class') == 'minus'){
            if(count > 1) {
                count--;
                total_cost.html(parseInt(total_cost.html())-(parseInt(price_input.text())));
            }
        } else {
            count++;
            total_cost.html(parseInt(total_cost.html())+(parseInt(price_input.text())));
        }
		count_input.val(count);
		price_total_input.text((parseInt(price_input.text()) * count));
		// обновление количества для базы
		update_product_cart_count(product_article, count);
	});
    $('.numbertype').keyup(function() {
        var product_article = $(this).parents('.prod-in-cart').data('product-article');
        var parent_block = $(".prod-in-cart[data-product-article='"+product_article+"']");
        var price_input = parent_block.find('.price_one');
        var price_total_input = parent_block.find('.price_all');
        var count = $(this).val();
        if (count.length<1 || parseInt(count)<0){
            $(this).val(1).keyup();
            return false;
        }
        price_total_input.html(parseInt(price_input.text())*count);
        var total_cost = $('.total_cost').find('.price_total');
        total_cost.html(0);
        $('.price_all').each(function() {
            total_cost.html(parseInt(total_cost.html())+parseInt($(this).html()));
        });
        update_product_cart_count(product_article, count);
    });
	// product delete from cart
	$('.prod-delete-button').on("click", function(e) {
		var product_article = $(this).parents('.prod-in-cart').data('product-article');
        var cart_id = $(this).data('cart_id');
        var price_total_input = $(".prod-in-cart[data-product-article='"+product_article+"']").find('.price_all');
        var total_cost = $('.total_cost').find('.price_total');

        if (typeof sub_area == 'undefined'){
	        sub_area = product_article;
	    }
		$.post(
	        "/index.ajax.php",
	        {
	            area        : 'profile',
	            sub_area    : sub_area,
                cart_id     : cart_id,
	            action      : 'delete_product_from_cart'
	        },
	        function(json){
	        	if(json['result']!=false) {
	        		//console.log(json['result_msg']);
    				$(".prod-in-cart[data-product-article='"+product_article+"']").remove();
                    total_cost.html(parseInt(total_cost.html())-(parseInt(price_total_input.text())));
                    if($(".cart-wrapper").find(".prod-in-cart").length == 0) $('.cart-wrapper').slideToggle();
                    remove_button();
	        	}
	        },
	        'json'
	    );
        return false;
	});

    $('form').find('input').each(function() {
        var val = $(this).val();
        if (($(this).attr('id')=='user_bank_name' || $(this).attr('id')=='user_bank_contact_fullname')
            && val.length==0){
            $(this).val($('#user_fullname').val());
        } else if ($(this).attr('id')=='user_bank_contact_phone' && val.length==0){
            $(this).val($('#user_phone').val());
        }
    });

	function update_product_cart_count(product_article, count) {
		if (typeof sub_area == 'undefined'){
	        sub_area = product_article;
	    }
		$.post(
	        "/index.ajax.php",
	        {
	            area        : 'profile',
	            sub_area    : sub_area,
	            action      : 'update_product_count',
	            products_cart_count : count
	        },
	        function(json){
	        	if(json['result']!=false) {
	        		//console.log(json['result_msg']);
	        	}
	        },
	        'json'
	    );
	}
	
	// ===== Блок обработки способов доставки =====
	// скрываем/отображаем товар
	$('.seller_hide_position').on("click", function(e) {
		var seller_status_obj = $(this);
		var product_article = $(this).parent().parent().data('product-article');
		
		if (typeof sub_area == 'undefined'){
	        sub_area = product_article;
	    }
		$.post(
	        "/index.ajax.php",
	        {
	            area        : 'profile',
	            sub_area    : sub_area,
	            action      : 'change_product_state'
	        },
	        function(json){
	        	if(json['result']!=false) {
	        		seller_status_obj.html(json['result_status']);
	        	}
	        },
	        'json'
	    );
	});
	// удаление товара из списка продавца
	$('.seller_del_position').on("click", function(e) {
		var product_article = $(this).parent().parent().data('product-article');
		
		if (typeof sub_area == 'undefined'){
	        sub_area = product_article;
	    }
		$.post(
	        "/index.ajax.php",
	        {
	            area        : 'profile',
	            sub_area    : sub_area,
	            action      : 'delete_product_from_sellers_list'
	        },
	        function(json){
	        	if(json['result']!=false) {
    				$(".your-product[data-product-article='"+product_article+"']").remove();
	        	}
	        },
	        'json'
	    );
	});

    // замена заголовка блока дополнительной информации о доставке
    $('select[name*="delivery"]').each(function(){
        change_delivery_info_title(this);
    }).change(function(){
        change_delivery_info_title(this);
    });

});