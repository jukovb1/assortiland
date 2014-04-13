var result_ajax = "#result_ajax";
var body = "body";
var submit_stop = false;
var admin_folder = '';
var confirm_text = '';
var lang_abbr = '';


function empty( mixed_var ) {	// Determine whether a variable is empty
    //
    // +   original by: Philippe Baumann

    return ( mixed_var === "" || mixed_var === 0   || mixed_var === "0" || mixed_var === null  || mixed_var === false  ||  ( typeof mixed_var == 'array' && mixed_var.length === 0 ) );
}

function show_lang_tabs(that,lang_id){
    if (typeof lang_id == 'undefined'){
        lang_id = that.data('lang_id');
    }
    $('.mod_lang_tab_item').removeClass('mod_lang_tab_item_active');
    that.addClass('mod_lang_tab_item_active');
    $('[class*="field_lang_area_"]').hide();
    $('.field_lang_area_'+lang_id).show();
}

function checked_all(){
    $('input:checkbox:enabled').attr('checked', true);
    $('.niceCheck:not([class*="niceCheckDisabled"])').addClass('niceChecked');
}
function show_popup(to_scroll){
    if (typeof to_scroll === 'undefined'){
        to_scroll = false;
    }
    if (to_scroll) {
        $(body).addClass('no_scroll');
        $(result_ajax).addClass('to_scroll');
    }
    $(result_ajax).parent().show();
}
function hide_popup(time_out){
    if (typeof time_out == 'undefined'){
        time_out = 1;
    }
    setTimeout(function(){
        if ($(result_ajax).hasClass('no_auto_hide')==false){
            $(body).removeClass('no_scroll');
            $(result_ajax)
                .removeClass('ok')
                .removeClass('msg_ok')
                .removeClass('msg_err')
                .removeClass('to_scroll')
                .removeClass('error')
                .html('')
                .parent().hide()
        }

    },time_out);
}

function unchecked_all(){
    $('input[id*="chbx_"]').attr('checked', false);
    $('.niceCheck').removeClass('niceChecked');
}
function nl2br(str){
    return str.replace(/([^>])\n/g, '$1<br/>');
}

function checkbox_status(checkbox)
{
    if($(checkbox).prop("checked")) {
        $(checkbox).nextAll('.chbx_input').val('1');
    } else {
        $(checkbox).nextAll('.chbx_input').val('0');
    }
}

function select_all_chbx(that){
    if ($(that).is('span')){
        if ($(that).find('input[id*="select_all_chbx"]').length>0){
            if($(that).hasClass('niceChecked')==true){
                checked_all();
            } else {
                unchecked_all()
            }
        } else{
            if($(that).hasClass('niceChecked')==false){
                if ($('.niceChecked').find('input:not([id*="select_all_chbx"])').length==0){
                    unchecked_all()
                }
            }
        }
    } else {
        if($(that).attr('checked')){
            checked_all();
        } else {
            unchecked_all();
        }
    }
}



function setting_the_admin_table(){
    var table_class = '.drv-content-table';
    if ($(table_class).length>0){
        // дублируем названия колонок из хедера таблицы в футер
        $(table_class).find('tfoot').html($(table_class).find('thead').html());
        // устанавливаем правильный colspan там, где нужно
        var colspan = $(table_class).find('thead').find('th').length;
        console.log(colspan);
        $(table_class).find('td.del_status').attr('colspan',colspan);
        $(table_class).find('td.no_data_td').attr('colspan',colspan);
    }
}


$(document).ready(function($) {

    setting_the_admin_table();

    hide_popup(5000);

    admin_folder = $(body).data('admin_folder');
    confirm_text = $(body).data('confirm_text');
    lang_abbr = $(body).data('lang_abbr');

    $(body).on('click','.niceCheck',function(){
        if($(this).find('input').prop('checked')){
            $(this).next('input').val(1);
        } else {
            $(this).next('input').val(0);
        }
    });



    // drop down select
    $(".cusel").each(function() {
        var w = parseInt($(this).width()),
            scrollPanel = $(this).find(".cusel-scroll-pane");
        if(w>=scrollPanel.width()) {
            $(this).find(".jScrollPaneContainer").width(w);
            scrollPanel.width(w);
        }
    });



    $("#sort").addClass("cuselBorder");
    $(body).on('change','input[id*="select_all_chbx"]',function(){
        select_all_chbx(this);
    });
    $(body).on('click','.niceCheck',function(){
        select_all_chbx(this);
    });




    $('.dark_bg').click(function(e){
        if (this === e.target) hide_popup();
    });

    document.onkeydown = function(e) {
        e = e || window.event;
        if (e.keyCode == 27) {
            hide_popup();
        }
        return true;
    };

    $('.mod_lang_tab_item').click(function(){
        $('.mod_lang_tab_item').removeClass('mod_lang_tab_item_active');
        var lang_id = $(this).data('lang_id');
        $(this).addClass('mod_lang_tab_item_active');
        $('[class*="field_lang_area_"]').hide();
        $('.field_lang_area_'+lang_id).show();
    });

    $('.redirect_button').click(function(){
        document.location.href = $(this).data('redirect');
    });

    $('.hide_menu,.hide_menu div').innerHeight($('.drv-wrapper').innerHeight()+45);

    var menu_status = true;
    $('.hide_menu').click(function() {
        var title = $(this).attr("title");
        var alt_title = $(this).data("alt_title");
        $(this).data("alt_title",title).attr('title',alt_title);
        if (menu_status) {
            menu_status = false;
            $('.drv-menu-wrapper').hide();
            $('.drv-content-wrapper').css({marginLeft:"40px"});
        } else {
            menu_status = true;
            $('.drv-menu-wrapper').show();
            $('.drv-content-wrapper').css({marginLeft:"260px"});
        }
    });

    var default_path = $('.search_order_form').attr('action');
    $('.search_order').blur(function() {
        var that = $(this);
        that.parent('form').attr('action',default_path+$(this).val());
        $('.search_order_go').click(function() {
            if (that.parent('form').attr('action')!=default_path) {
                $(this).parent('form').submit();
            }
        });
    });
});