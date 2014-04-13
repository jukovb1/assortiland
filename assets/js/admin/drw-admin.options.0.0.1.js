function get_lang_file_data() {
    var lang_data = null;
    $.ajaxSetup({async:false});
    $.post(
        "/"+admin_folder+"/index.ajax.php",
        {
            area        : 'options',
            sub_area    : 'options',
            action      : 'get_lang_file_data'
        },
        function(json){
            if(json['result']!=false) {
                lang_data = json['result_data'];
            }
        },
        'json'
    );
    $.ajaxSetup({async:true});
    return lang_data;
}
function get_delivery_data() {
    var delivery_data = null;
    $.ajaxSetup({async:false});
    $.post(
        "/"+admin_folder+"/index.ajax.php",
        {
            area        : 'options',
            sub_area    : 'options',
            action      : 'get_delivery_data'
        },
        function(json){
            if(json['result']) {
                delivery_data = json['result_data'];
            }
        },
        'json'
    );
    $.ajaxSetup({async:true});
    return delivery_data;
}
function delete_delivery(id,is_confirm) {
    $.ajaxSetup({async:false});
    if (typeof is_confirm == 'undefined'){
        is_confirm = false;
    }
    var delivery_data = null;
    $.post(
        "/"+admin_folder+"/index.ajax.php",
        {
            area        : 'options',
            sub_area    : 'options',
            id          : id,
            is_confirm     : is_confirm,
            action      : 'delete_delivery'
        },
        function(json){
            if(json['result']=='confirm') {
                if (confirm(json['result_msg'])){
                    delivery_data = delete_delivery(id,true);
                }
            } else if(json['result']==true){
                delivery_data = json['result_msg'];
            }
        },
        'json'
    );
    $.ajaxSetup({async:true});
    return delivery_data;
}

function get_content_and_sliders_data() {
	var cont_slid_data = null;
	$.ajaxSetup({async:false});
	$.post(
		"/"+admin_folder+"/index.ajax.php",
		{
			area        : 'options',
			sub_area    : 'options',
			action      : 'get_content_and_sliders_data'
		},
		function(json){
			if(json['result']!=false) {
				cont_slid_data = json['result_data'];
			}
		},
		'json'
	);
	$.ajaxSetup({async:true});
	return cont_slid_data;
}

$(document).ready(function($) {
    var lang_texts = get_lang_file_data();

    $('body').on('change','#change_module_group',function(){
        var option_index = $(this).val();
        document.location.href = option_index;
    });

    var params = {
        changedEl: "#change_module_group",
        scrollArrows: true
    };
    cuSel(params);

    $("#change_module_group").addClass("cuselBorder");


    $(".redactor").each(function(){
        var lang_abbr = $('body').data('lang_abbr');
        $(this).redactor({lang: lang_abbr});
    });

    // ===== Блок обработки способов доставки =====
    var delivery_services_obj = $("textarea[name*='delivery_services']");
    // проверяем находимся ли мы в блоке доставки
    if(delivery_services_obj.length>0) {

        delivery_services_obj.each(function() {
            var cur_textarea = $(this);
            cur_textarea.wrap('<div></div>');
            var lang_id = 1;
            cur_textarea.hide();
            var delivery_services_parent = cur_textarea.parent();
            delivery_services_parent.append("<div class='inputs_wrapper_"+lang_id+"'></div>");

            var delivery_data = get_delivery_data();
            console.log(delivery_data);
            $(".inputs_wrapper_"+lang_id).append("");
            for (var k in delivery_data){
                // проверяем поля на заполненность
                delivery_set(".inputs_wrapper_"+lang_id,delivery_data[k]);
            }
            delivery_services_parent.append(
                "<div class='drv-options-delivery-cover cover_"+lang_id+"'>" +
                    "<span class='drv-option-add'></span>" +
                    "<br style='clear: both'>" +
                    "</div>");

            $('body').on('click', '.drv-option-remove', function() {
                if (confirm(lang_texts["{confirm_delete_obj}"])) {
                    var delivery_id = $(this).data('delivery_id');
                    if (delivery_id=='none'){
                        $(this).parent().remove();
                        inputs_val_to_textarea();
                    } else {
                        var del_result = delete_delivery(delivery_id);
                        if (typeof del_result=='string'){
                            $(this).parent().remove();
                        }
                    }

                }
            });

            function delivery_set(parent_obj,data) {
                var d_name = data['option_str_val'];
                var d_id = data['option_id'];
                $(parent_obj).append("<div class='drv-options-delivery-cover cover_"+lang_id+"'>" +
                    "<div class='drv-lines' style='display: inline-block;background: #f3f3f3'>" + d_name + "</div>" +
                    "<span data-delivery_id='"+d_id+"' class='drv-option-remove'></span><br style='clear: both'>" +
                    "</div>");
            }
            function inputs_set(parent_obj,title) {
                if (typeof title == 'undefined')title = '';
                $(parent_obj).append("<div class='drv-options-delivery-cover cover_"+lang_id+"'>" +
                    "<input class='drv-options-delivery drv-lines' value='"+title+"' type='text'>" +
                    "<span data-delivery_id='none' class='drv-option-remove'></span>" +
                    "</div>");
            }
            function inputs_val_to_textarea() {
                var delivery = [];
                var result_arr = [];
                var i = 0;
                $(".cover_"+lang_id).each(function(){
                    delivery[i] = $(this).find('.drv-options-delivery').map(function(){
                        return $(this).val();
                    }).get();
                    if(delivery[i]!=''){
                        result_arr.push(delivery[i]);
                    }
                    i++;
                });
                cur_textarea.val(result_arr);
            }
            // при потере фокуса у инпута
            $('body').on('blur', '.drv-lines', inputs_val_to_textarea);
            $('body').on('keyup', '.drv-lines', inputs_val_to_textarea);
            $('body').on('click', '.drv-option-add', function() {
                inputs_set(".inputs_wrapper_"+lang_id);
            });

        });
    }

    // ===== Блок обработки главного меню =====
    var main_menu_obj = $("textarea[name*='site_main_menu']");
    // проверяем находимся ли мы в блоке меню
    if(main_menu_obj.length) {

        main_menu_obj.each(function() {
            var cur_textarea = $(this);
            // тут получаю id языка из name текстового поля,
            // если знаешь как это сделать короче, перепиши
            var text_name_split = cur_textarea.attr('name').split("[");
            var lang_id = text_name_split[1].substring(0, text_name_split[1].length - 1);

            $(this).hide();
            var main_menu_parent = $(this).parent();
            main_menu_parent.append("<div class='inputs_wrapper_"+lang_id+"'></div>");
            var menu_items = $(this).val().split(',');
            for (var x in menu_items){
                var menu_item = menu_items[x].split('|');
                var anchor = $.trim(menu_item[0]);
                var url = $.trim(menu_item[1]);
                // проверяем поля на заполненность
                if(anchor.length>0 || url.length>0) {
                    inputs_set(".inputs_wrapper_"+lang_id,anchor,url);
                }
            }
            main_menu_parent.append("<div class='drv-options-main-menu-cover cover_"+lang_id+"'><span class='drv-option-add'></span><br style='clear: both'></div>");

            $('body').on('click', '.drv-option-remove', function() {
                if (confirm(lang_texts["{confirm_delete_obj}"])) {
                    $(this).parent().remove();
                    inputs_val_to_textarea();
                }
            });

            function inputs_set(parent_obj,anchor,url) {
                if (typeof anchor == 'undefined')anchor = '';
                if (typeof url == 'undefined')url = '';
                $(parent_obj).append("<div class='drv-options-main-menu-cover cover_"+lang_id+"'>" +
                    "<input class='drv-options-main-menu drv-lines' value='"+anchor+"' type='text'>" +
                    "<input class='drv-options-main-menu drv-lines' value='"+url+"' type='text'>" +
                    "<span class='drv-option-remove'></span>" +
                    "</div>");
            }
            function inputs_val_to_textarea() {
                var menu = [];
                var result_arr = [];
                var i = 0;
                $(".cover_"+lang_id).each(function(){
                    menu[i] = $(this).find('.drv-options-main-menu').map(function(){
                        return $(this).val();
                    })
                        .get()
                        .join('|');
                    if(menu[i]!='|' && menu[i]!=''){
                        result_arr.push(menu[i]);
                    }
                    i++;
                });
                cur_textarea.val(result_arr.join(','));
            }
            // при потере фокуса у инпута
            $('body').on('blur', '.drv-lines', inputs_val_to_textarea);
            $('body').on('click', '.drv-option-add', function() {
                inputs_set(".inputs_wrapper_"+lang_id);
            });
        });

    }

    // ===== Блок обработки слайдов =====
    var slides_obj = $("textarea[name*='site_slides']");
    // проверяем находимся ли мы в блоке слайдов
    if(slides_obj.length) {


        slides_obj.each(function() {
            var cur_textarea = $(this);
            // тут получаю id языка из name текстового поля,
            // если знаешь как это сделать короче, перепиши
            var text_name_split = cur_textarea.attr('name').split("[");
            var lang_id = text_name_split[1].substring(0, text_name_split[1].length - 1);

            $(this).hide();
            var slides_parent = $(this).parent();
            slides_parent.append("<div class='inputs_wrapper_"+lang_id+"'></div>");
            var menu_items = $(this).val().split(';');
            for (var x in menu_items){
                var menu_item = menu_items[x].split('|');
                var fields_array = {};
                fields_array['alias'] = $.trim(menu_item[0]);
                fields_array['title'] = $.trim(menu_item[1]);
                fields_array['sub_title'] = $.trim(menu_item[2]);
                fields_array['desc'] = $.trim(menu_item[3]);
                fields_array['button_anchor'] = $.trim(menu_item[4]);
                fields_array['button_url'] = $.trim(menu_item[5]);
                fields_array['image_url'] = $.trim(menu_item[6]);
                var is_ok = false;
                for(var x in fields_array){
                    if (fields_array[x].length>0){
                        is_ok = true;
                    }
                }
                // проверяем поля на заполненность
                if(is_ok) {
                    inputs_set(".inputs_wrapper_"+lang_id,fields_array);
                }
            }
            slides_parent.append("<div class='drv-options-main-menu-cover cover_"+lang_id+"'><span class='drv-option-add'></span><br style='clear: both'></div>");

            $('body').on('click', '.drv-option-remove', function() {
                if (confirm(lang_texts["{confirm_delete_obj}"])) {
                    $(this).parent().remove();
                    inputs_val_to_textarea();
                }
            });

            function inputs_set(parent_obj,fields_array) {
                if (typeof fields_array == 'undefined') {
                    fields_array = {};
                    fields_array['alias'] = '';
                    fields_array['title'] = '';
                    fields_array['sub_title'] = '';
                    fields_array['desc'] = '';
                    fields_array['button_anchor'] = '';
                    fields_array['button_url'] = '';
                    fields_array['image_url'] = '';
                }
                var field_set_html = "<div class='drv-options-slide-cover cover_"+lang_id+"'>";
                for(var field_name in fields_array){
                    var cur_lang = '{placeholder_'+field_name+'}';
                    if (typeof lang_texts['{placeholder_'+field_name+'}'] != 'undefined'){
                        cur_lang = lang_texts['{placeholder_'+field_name+'}'];
                    }
                    if (field_name == 'desc'){
                        field_set_html += "<textarea class='block_input drv-options-slide drv-lines' placeholder='"+cur_lang+"' title='"+cur_lang+"' >"+fields_array[field_name]+"</textarea>";
                    } else {
                    	var alias_class = '';
                    	if(field_name == 'alias') {
                    		alias_class = 'drv-alias-class ';
                    	}
                        field_set_html += "<input class='"+alias_class+"block_input drv-options-slide drv-options-article drv-lines' placeholder='"+cur_lang+"' title='"+cur_lang+"' value='"+fields_array[field_name]+"' type='text'>";
                    }
                }
                field_set_html += "<span class='drv-option-remove'></span>";
                field_set_html += "<br style='clear: both'>";
                field_set_html += "</div>";
                $(parent_obj).append(field_set_html);
            }
            function inputs_val_to_textarea() {
                var menu = [];
                var result_arr = [];
                var i = 0;
                $(".cover_"+lang_id).each(function(){
                    menu[i] = $(this).find('.drv-options-slide').map(function(){
                    	if($(this).val()!='')
                        	return $(this).val();
                        else return '';
                    })
                        .get()
                        .join('|');
                    if(menu[i]!='|' && menu[i]!=''){
                        result_arr.push(menu[i]);
                    }
                    i++;
                });
                cur_textarea.val(result_arr.join(';'));
            }
            function check_non_latin_for_article() {
                $(this).val($(this).val().replace(/[^a-z0-9_]/i, ""));
            }

            // проверка вводимых символов в поле артикула
            $('body').on('keyup', '.drv-alias-class', check_non_latin_for_article);
            // при потере фокуса у инпута
            $('body').on('blur', '.drv-lines', inputs_val_to_textarea);
            $('body').on('click', '.drv-option-add', function() {
                inputs_set(".inputs_wrapper_"+lang_id);
            });
        });


    }

    // ===== Блок обработки слайдеров =====
    var sliders_obj = $("textarea[name*='site_sliders']");
    // проверяем находимся ли мы в блоке слайдеров
    if(sliders_obj.length) {
		var content_and_slides = get_content_and_sliders_data();
		sliders_obj.each(function() {
            var cur_textarea = $(this);
            // тут получаю id языка из name текстового поля,
            // если знаешь как это сделать короче, перепиши
            var text_name_split = cur_textarea.attr('name').split("[");
            var lang_id = text_name_split[1].substring(0, text_name_split[1].length - 1);

            $(this).hide();
            var saved_data = parse_saved_sliders($(this).val(),lang_id);
            var sliders_parent = $(this).parent();
            sliders_parent.append("<div class='inputs_wrapper_"+lang_id+"'></div>");
            
            for (var i in content_and_slides['content']){
	            var is_ok = false;
	            if (content_and_slides['content'][i].length>0){
	                is_ok = true;
	            }
	            // проверяем поля на заполненность
	            if(is_ok) {
	                inputs_set(saved_data,".inputs_wrapper_"+lang_id,content_and_slides['content'][i],content_and_slides['slides'][lang_id]);
	            }
            }
            sliders_parent.append("<div class='drv-options-main-menu-cover cover_"+lang_id+"'><br style='clear: both'></div>");

            function parse_saved_sliders(saved_data,lang_id) {
                var return_arr = {};
                return_arr[lang_id] = {};
                if (saved_data.length>0){
	                var saved_sliders = saved_data.split(',');
	                for (var x in saved_sliders){
	                    var saved_sliders_arr = saved_sliders[x].split('|');
	                    if (saved_sliders_arr[1].length>0){
	                        var saved_slides = saved_sliders_arr[1].split(';');
	                        return_arr[lang_id][saved_sliders_arr[0]] = {};
	                        for (var k in saved_slides) {
	                            return_arr[lang_id][saved_sliders_arr[0]][saved_slides[k]] = saved_slides[k];
	                        }
	                    }
	                }
                }
                return return_arr[lang_id];
            }
            function inputs_set(saved_data,parent_obj,label,slides) {

                if (typeof label == 'undefined') {
                    label = '';
                }
                var field_set_html = "<div class='drv-options-slider-cover cover_"+lang_id+"'>";
                field_set_html += "<label class='drv-options-slider'>"+label+"</label>";

                if(slides.length>0) {
                	field_set_html += "<select multiple class='drv-options-slider-select'>";
	                for(var x in slides){
	                	var slide = slides[x].split('|');
		                var slide_alias = $.trim(slide[0]);
		                if(slide_alias.length>0) {
                            var selected = '';
                            if (typeof saved_data[label] != 'undefined'
                                && typeof saved_data[label][slide_alias] != 'undefined'){
                                selected = "selected='selected'";
                            }
                            field_set_html += "<option "+selected+" value='"+slide_alias+"'>"+slide_alias+"</option>";
                        }
	                }
	                field_set_html += "</select>";
                }
                field_set_html += "<br style='clear: both'>";
                field_set_html += "</div>";
                $(parent_obj).append(field_set_html);
            }
            function inputs_val_to_textarea() {
                var menu = [];
                var result_arr = [];
                var i = 0;
                $(".cover_"+lang_id).each(function(){
                	menu[i] = $(this).find('.drv-options-slider').text() + "|";
                    menu[i] += $(this).find('.drv-options-slider-select option:selected').map(function(){
                    	if($(this).text()!='')
                        	return $(this).text();
                    })
                        .get()
                        .join(';');
                    if(menu[i]!='|' && menu[i]!=''){
                        result_arr.push(menu[i]);
                    }
                    i++;
                });
                cur_textarea.val(result_arr.join(','));
            }

            // при потере фокуса у инпута
            $('body').on('blur', '.drv-options-slider-select', inputs_val_to_textarea);
        });
    }
    
    // ===== Блок обработки цитат =====
    var quotes_obj = $("textarea[name*='site_quotes']");
    // проверяем находимся ли мы в блоке меню
    if(quotes_obj.length) {

        quotes_obj.each(function() {
            var cur_textarea = $(this);
            // тут получаю id языка из name текстового поля,
            // если знаешь как это сделать короче, перепиши
            var text_name_split = cur_textarea.attr('name').split("[");
            var lang_id = text_name_split[1].substring(0, text_name_split[1].length - 1);

            $(this).hide();
            var quotes_parent = $(this).parent();
            quotes_parent.append("<div class='inputs_wrapper_"+lang_id+"'></div>");
            var quotes_items = $(this).val().split(';');
            for (var x in quotes_items){
                var quotes_item = quotes_items[x].split('|');
                var author = $.trim(quotes_item[0]);
                var quote = $.trim(quotes_item[1]);
                // проверяем поля на заполненность
                if(author.length>0 || quote.length>0) {
                    inputs_set(".inputs_wrapper_"+lang_id,author,quote);
                }
            }
            quotes_parent.append("<div class='drv-options-main-menu-cover cover_"+lang_id+"'><span class='drv-option-add'></span><br style='clear: both'></div>");

            $('body').on('click', '.drv-option-remove', function() {
                if (confirm(lang_texts["{confirm_delete_obj}"])) {
                    $(this).parent().remove();
                    inputs_val_to_textarea();
                }
            });

            function inputs_set(parent_obj,author,quote) {
                if (typeof author == 'undefined')author = '';
                if (typeof quote == 'undefined')quote = '';
                $(parent_obj).append("<div class='drv-options-main-menu-cover cover_"+lang_id+"'>" +
                    "<input class='drv-options-main-menu drv-lines' value='"+author+"' type='text'>" +
                    "<input class='drv-options-main-menu drv-lines' value='"+quote+"' type='text'>" +
                    "<span class='drv-option-remove'></span>" +
                    "</div>");
            }
            function inputs_val_to_textarea() {
                var menu = [];
                var result_arr = [];
                var i = 0;
                $(".cover_"+lang_id).each(function(){
                    menu[i] = $(this).find('.drv-options-main-menu').map(function(){
                        return $(this).val();
                    })
                        .get()
                        .join('|');
                    if(menu[i]!='|' && menu[i]!=''){
                        result_arr.push(menu[i]);
                    }
                    i++;
                });
                cur_textarea.val(result_arr.join(';'));
            }
            // при потере фокуса у инпута
            $('body').on('blur', '.drv-lines', inputs_val_to_textarea);
            $('body').on('click', '.drv-option-add', function() {
                inputs_set(".inputs_wrapper_"+lang_id);
            });
        });

    }

    // обработка чекбоксов
    var checkboxes = $("input[type='checkbox']");
    if (checkboxes.length>0){
        $('body').on('change', "input[type='checkbox']", function() {
            if($(this).prop("checked")) {
                $(this).prev(".hidden_for_checkbox").val('1');
            } else {
                $(this).prev(".hidden_for_checkbox").val('0');
            }
        });
    }
});