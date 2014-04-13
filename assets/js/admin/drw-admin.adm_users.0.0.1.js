

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
        sub_area = 'users-groups';
    }
    $.post(
        "/"+admin_folder+"/index.ajax.php",
        {
            area        : 'adm_users',
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

function change_status_of_waiting(cont_id,action,admin_folder,lang_abbr) {
	var tr = $('.tr_'+cont_id);
	
	if (typeof sub_area == 'undefined'){
        sub_area = 'users-wait';
    }
    $.post(
        "/"+admin_folder+"/index.ajax.php",
        {
            area        : 'adm_users',
            sub_area    : sub_area,
            action      : 'status_of_waiting',
            id          : cont_id,
            data_action	: action
        },
        function(json){
            show_popup();
            $(result_ajax).html(nl2br(json['result_msg']));
            if(json['result']==false) {
                $(result_ajax).addClass('msg_err');
                hide_popup(10000);
            } else {
                tr.hide();
            	$(result_ajax).addClass('msg_ok');
                hide_popup(2000);
            }
        },
        'json'
    );
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


$(document).ready(function($) {

    $(body).on('change','[type="range"]',function(){
        $(this).next('.range_info').html($(this).val());
    });

    $(body).on('keyup','#user_login',function(){
        $(this).attr('autocomplete','off');
        var user_id = $('[name="user_id"]').val();
        var value = $('#user_login').val();
        $('#isset_login').remove();
        submit_stop = false;

        $.post(
            "/"+admin_folder+"/index.ajax.php",
            {
                area        : 'adm_users',
                sub_area    : sub_area,
                action      : 'check_login',
                user_id     : user_id,
                user_login  : value
            },
            function(json){
                if(json['result']==false) {
                    $('#user_login').after('<div style="display: block" id="isset_login" class="show_required_text">'+nl2br(json['result_msg'])+'</div>');
                    submit_stop = true;
                    $(this).focus();
                }
            },
            'json'
        );
    });
    $('input[pattern]').blur(function(){
        if (typeof $(this).attr('required')=='undefined'){
            if ($(this).val().length>0){
                check_validattion(this);
            }
        } else {
            check_validattion(this);
        }
    });

    $(".redactor").each(function(){
        var lang_abbr = $('body').data('lang_abbr');
        $(this).redactor({lang: lang_abbr});
    });

    $('button:submit').click(function(){
        // ash-1 to mal-1 добавить проверку на равенство паролей
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
        }
        if (submit_stop == true || submit_stop_r == true){
            return false;
        }
    });

    var params = {
        changedEl: "#sort",
        visRows: 5,
        scrollArrows: true
    };
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
    $('.change_status_in_group').click(function(){
        var cont_id = $(this).parent('.drv-item-edit').data('cont_id');
        var action = $(this).data('action');
        change_status_of_waiting(cont_id,action,admin_folder,lang_abbr);

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


});