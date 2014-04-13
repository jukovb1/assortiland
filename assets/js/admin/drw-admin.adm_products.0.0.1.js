

function change_status(cont_id,old_status,new_status,admin_folder,lang_abbr,parent_id){
    var sh = '.sh';
    var sh2 = '.sh2';
    var st = '.status_txt_';
    var alt_text,cur_text,alt_text2,cur_text2;
    alt_text = $(sh+"_"+cont_id).data('alt_text');
    cur_text = $(sh+"_"+cont_id).html();
    alt_text2 = $(st+cont_id).data('alt_text');
    cur_text2 = $(st+cont_id).html();

    var tr = $('.tr_'+cont_id);
    tr.find('td.del_status').find('.change_status').attr('data-action',old_status);
    if (typeof parent_id == 'undefined'){
        parent = tr.data('parent');
    } else {
        parent = parent_id;
    }
    var tr2 = tr.next();
    if (tr2.data('parent') != parent && tr2.data('parent')!=0){
        var cont_id2 = tr2.data('cont_id');
        change_status(cont_id2,old_status,new_status,admin_folder,lang_abbr,parent);
    }
    if (typeof sub_area == 'undefined'){
        sub_area = 'products-groups';
    }
    $.post(
        "/"+admin_folder+"/index.ajax.php",
        {
            area        : 'adm_products',
            sub_area    : sub_area,
            action      : 'status',
            id          : cont_id,
            new_status  : new_status,
            old_status  : old_status,
            lang_abbr   : lang_abbr
        },
        function(json){
            show_popup();
            $(result_ajax).html(nl2br(json['result_msg']));
            if(json['result']==false) {
                $(result_ajax).addClass('msg_err');
                hide_popup(10000);
            } else {
                if (old_status == 0 && new_status == 1) {
                    $(sh+"_"+cont_id)
                        .data('alt_text',cur_text)
                        .html(alt_text)
                        .data('action',0)
                        .data('cur_status',1)
                    ;
                    $(sh2+"_"+cont_id).data('cur_status',1);
                    tr.removeClass('hide_row');
                    $(st+cont_id)
                        .removeClass('drv-date-status-hide')
                        .addClass('drv-date-status')
                        .data('alt_text',cur_text2)
                        .html(alt_text2)
                    ;
                } else if (old_status == 1 && new_status == 0) {
                    $(sh+"_"+cont_id)
                        .data('alt_text',cur_text)
                        .html(alt_text)
                        .data('action',1)
                        .data('cur_status',0)
                    ;
                    $(sh2+"_"+cont_id).data('cur_status',0);
                    tr.addClass('hide_row');
                    $(st+cont_id)
                        .removeClass('drv-date-status')
                        .addClass('drv-date-status-hide')
                        .data('alt_text',cur_text2)
                        .html(alt_text2)
                    ;
                } else if (new_status == -1) {
                    tr.addClass('deleted_row').find('td').not('.del_status').hide();
                    tr.find('td.del_status').show();
                } else if (old_status == -1) {
                    tr.removeClass('deleted_row').find('td').not('.del_status').show();
                    tr.find('td.del_status').hide();

                }
                $(result_ajax).addClass('msg_ok');
                hide_popup(2000);
            }
        },
        'json'
    );
}
function change_global_percents(){
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
}



$(document).ready(function($) {
    change_global_percents();
    $('#pr_edit_param_11').blur(function() {
        change_global_percents();
    });
    $(body).on('blur','#pr_edit_param_5',change_global_percents);
    $(body).on('change','[type="range"]',function(){
        $(this).next('.range_info').html($(this).val());
    });

    $(body).on('keyup','#product_article',function(){
        $(this).attr('autocomplete','off');
        var product_id = $('[name="product_id"]').val();
        var value = $('#product_article').val();
        $('#isset_article').remove();
        submit_stop = false;

        $.post(
            "/"+admin_folder+"/index.ajax.php",
            {
                area        : 'adm_products',
                sub_area    : sub_area,
                action      : 'check_article',
                product_id  : product_id,
                article     : value
            },
            function(json){
                if(json['result']==false) {
                    $('#product_article').after('<div style="display: block" id="isset_article" class="show_required_text">'+nl2br(json['result_msg'])+'</div>');
                    submit_stop = true;
                    $(this).focus();
                }
            },
            'json'
        );
    });

    $(body).on('keyup','#group_short_name',function(){
        $(this).attr('autocomplete','off');
        if ($('[name="group_id"]').length>0){
            var group_id = $('[name="group_id"]').val();
        } else {
            group_id = 0;
        }
        var value = $(this).val();
        $('#isset_url').remove();
        submit_stop = false;

        $.post(
            "/"+admin_folder+"/index.ajax.php",
            {
                area        : 'adm_products',
                sub_area    : 'products-groups',
                action      : 'check_url',
                group_id    : group_id,
                url         : value
            },
            function(json){
                if(json['result']==false) {
                    $('#group_short_name').after('<div style="display: block" id="isset_url" class="show_required_text">'+nl2br(json['result_msg'])+'</div>');
                    submit_stop = true;
                    $(this).focus();
                }
            },
            'json'
        );
    });

    $('input[type=file]').change(function(){
        var this_name = $(this).attr('id');
        var cur_ext_string = $(this).data('cur_ext');
        var cur_ext_object = cur_ext_string.split(',');
        var parts = $(this).val().split('.');
        if(cur_ext_object.join().search(parts[parts.length - 1]) != -1){
            $('#'+this_name+'_wrong_ext').remove();
            submit_stop = false;
        } else {
            submit_stop = true;
            // ash-1 срочно вынести в языковой файл это сообщение
            $(this).after('<div style="display: block;margin-top: -3px;" id="'+this_name+'_wrong_ext" class="show_required_text">Не поддерживаемый формат</div>');
        }
    });

    $('button:submit').click(function(){
        submit_stop_r = false;
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
            }
        });
        $('select[required]').each(function(){
            if (submit_stop==false && (empty($(this).val())==true || $(this).val()=="0")){
                var lang_id = $(this).parent().data('lang_id');
                var destination = $(this).offset().top-50;
                $('body').animate({ scrollTop: destination }, 1100); //1100 - скорость
                $(this).focus().next('.show_required_text').slideDown();
                setTimeout(function(){
                    $('.show_required_text').slideUp();
                },5000);
                submit_stop_r = true;
            }
        });
        if (submit_stop == true || submit_stop_r == true){
            return false;
        }
    });

    cuSel(params);

    $('.change_status').click(function(){

        var cont_id = $(this).parent('.drv-item-edit').data('cont_id');
        var old_status = $(this).data('cur_status');
        var new_status = $(this).data('action');
        var confirm_del = false;
        if (new_status==-1){
            if (confirm(confirm_text)){
                confirm_del = true;
            }
        } else {
            confirm_del = true;
        }
        if (confirm_del){
            change_status(cont_id,old_status,new_status,admin_folder,lang_abbr);
        }

        return false;
    });
    $('.confirm_action').click(function(){
        var new_status = $('#sort').val();
        var confirm_del = false;
        if (new_status!="NULL"){
            if (new_status==-1){
                if (confirm(confirm_text)){
                    confirm_del = true;
                }
            } else {
                confirm_del = true;
            }
            if (confirm_del){
                var checked_chbx = $('input:checkbox:checked:not([id*="select_all_chbx"])');
                if (checked_chbx.length>0){
                    checked_chbx.each(function(){
                        var cont_id = $(this).parent().parent('td').data('cont_id');
                        var old_status = $(this).parent().parent('td').data('cur_status');
                        change_status(cont_id,old_status,new_status,admin_folder,lang_abbr);
                        unchecked_all();
                    });
                }
            }
        }
    });

	// изменяем тип для Акционных дат
	$('#product_date, #pr_edit_param_13, #pr_edit_param_14').attr({type:'date',class:'drv-lines-date'});
});