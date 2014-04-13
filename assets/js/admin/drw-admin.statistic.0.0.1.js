function change_status(cont_id,old_status,new_status,admin_folder,lang_abbr){
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
    $.post(
        "/"+admin_folder+"/index.ajax.php",
        {
            area        : 'statistic',
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
                if (old_status!=new_status) {
                    tr.remove();
                }
                $(result_ajax).addClass('msg_ok');
                hide_popup(2000);
            }
        },
        'json'
    );
}


$(document).ready(function($) {


    $(body).on('change','[type="range"]',function(){
        $(this).next('.range_info').html($(this).val());
    });

    $('.mod_lang_tab_item').click(function(){
        show_lang_tabs($(this));
    });

    $(body).on('keyup','#cont_url',function(){
        $(this).attr('autocomplete','off');
        if ($('[name="cont_id"]').length>0){
            var cont_id = $('[name="cont_id"]').val();
        } else {
            cont_id = 0;
        }
        var value = $(this).val();
        $('#isset_url').remove();
        submit_stop = false;

        $.post(
            "/"+admin_folder+"/index.ajax.php",
            {
                area        : 'content',
                action      : 'check_url',
                cont_id     : cont_id,
                url         : value
            },
            function(json){
                if(json['result']==false) {
                    $('#cont_url').after('<div style="display: block" id="isset_url" class="show_required_text">'+nl2br(json['result_msg'])+'</div>');
                    submit_stop = true;
                    $(this).focus();
                }
            },
            'json'
        );
    });

    $('button:submit').click(function(){
        submit_stop_r = false;
        if (empty($('#cont_files_2').val())==false && $('#cont_files_2').val()!=" "){
            $('#cont_files').removeAttr('required');
        } else {
            $('#cont_files').attr('required','required');
        }
        $('input[required],textarea[required]').each(function(){
            var this_id = $(this).attr('id');
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
        if (submit_stop == true || submit_stop_r == true){
            return false;
        }
    });

    var params = {
        changedEl: "#sort,#cont_user_id",
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



    $(".show_order_info2").click(function(){
        show_popup();
        $('#result_ajax').css('text-align','left').html($(this).next(".hidden_info").html());
        return false;
    });
    $(".show_order_info").click(function(){
        show_popup(true);
        $('#result_ajax').css('text-align','left').html($(this).next(".hidden_info").html());
        return false;
    });
});