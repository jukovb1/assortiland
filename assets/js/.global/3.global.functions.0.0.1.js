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


function nl2br(str){
    return str.replace(/([^>])\n/g, '$1<br/>');
}

function colspan_div_init() {
    $('.colspan_cell').each(function() {
        var table = $(this).parent().parent('.table');
        var cell_html = $(this).html();
        $(this).html('');
        var table_width = table.width()-1;
        $(this).html('<div class="colspan_child_1" style="width: 1px"><div class="colspan_child_2" style="width:'+table_width+'px;position:relative ">'+cell_html+'</div></div>');
    });
}


$(document).ready(function($) {


    hide_popup(5000);

    lang_abbr = $(body).data('lang_abbr');

    $('.dark_bg').click(function(){hide_popup();});

    document.onkeydown = function(e) {
        e = e || window.event;
        if (e.keyCode == 27) {
            hide_popup();
        }
        return true;
    };

    $('.redirect_button').click(function(){
        document.location.href = $(this).data('redirect');
    });

    // инициализация colspan в блочной таблице
    colspan_div_init();

});