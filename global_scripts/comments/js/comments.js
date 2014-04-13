var timeout = 30;  // таймаут на повторную отправку в секундах
var remaining_time = 0; // время до повторной отправки в секундах
var allowed_comments = true;


if (typeof body == 'undefined') var body = 'body';

function run_time() {
    if (remaining_time>=0){
        setTimeout(function() {
            $('.show_dop_text').each(function() {
                $(this).find('.comment_timeout').html(timeout);
                $(this).find('.comment_remaining_time').html(remaining_time)

            });
            allowed_comments = false;
            remaining_time--;
            run_time();
        },1000);
    } else {
        allowed_comments = true;
        $('.show_dop_text').hide();
    }
}


$(document).ready(function() {
    $(body).on('keyup','.comment_text',function(e) {
        $('.comment_text').val($(this).val());
        if (e.ctrlKey && e.keyCode == 13) {
            $(this).nextAll('.send_comment').click();
        }
    });
    $(body).on('click','.send_comment',function() {
        var comments_list_block = $('.comments_list');
        var module_name = comments_list_block.data('module');
        var target_id = comments_list_block.data('target_id');

        var text = $(this).prevAll('.comment_text').val();
        if (text.length==0){
            $(this).prevAll('.show_required_text').show();
            setTimeout(function() {
                $('.show_required_text').hide();
            },2000);
        } else if (allowed_comments==false){
            $(this).prevAll('.show_dop_text').show();
        } else {
            remaining_time = timeout;
            run_time();

            $.post(
                "/index.ajax.php",
                {
                    area        : 'comments',
                    action      : 'add_comment',
                    text        : text,
                    module      : module_name,
                    target_id   : target_id
                },
                function(json){
                    //show_popup();
                    //$(result_ajax).html(nl2br(json['result_msg']));
                    if(json['result']==false) {
                        //$(result_ajax).addClass('msg_err');
                        //hide_popup(10000);
                    } else {
                        comments_list_block.replaceWith(json['result_data']);
                        $('.comment_text').val('').focus();
                        $('#last_comment').css('background','rgba(56, 147, 208, 0.3)');
                        $("html:not(:animated),body:not(:animated)").animate({scrollTop:  $('#last_comment').position().top-100}, 800);
                        //$(result_ajax).addClass('msg_ok');
                        //hide_popup(2000);
                    }
                },
                'json'
            );
        }
    });


    $(body).on('click','.comment_del',function() {
        var comments_list_block = $('.comments_list');
        var module_name = comments_list_block.data('module');
        var target_id = comments_list_block.data('target_id');

        var comment_id = $(this).data('comment_id');
        var comment_del_status = $(this).data('comment_del_status');
        var comment_recovery = $(this).data('comment_recovery');
        var comment_block = $(this).parents('.my_comment');
        if (comment_block.hasClass('comment_deleted') == false){
            comment_block.addClass('comment_deleted');
            $.post(
                "/index.ajax.php",
                {
                    area        : 'comments',
                    action      : 'del_comment',
                    comment_id  : comment_id,
                    module      : module_name,
                    target_id   : target_id
                },
                function(json){
                    //show_popup();
                    //$(result_ajax).html(nl2br(json['result_msg']));
                    if(json['result']==false) {
                        comment_block.removeClass('comment_deleted');
                        //$(result_ajax).addClass('msg_err');
                        //hide_popup(10000);
                    } else {
                        comment_block.find('.comment_header').hide();
                        comment_block.find('.comment_text').hide();
                        comment_block.append('<div class="recovery_block">'+comment_del_status+' <a href="#" class="action_recovery" data-comment_id="'+comment_id+'">'+comment_recovery+'</a></div>');
                        //$(result_ajax).addClass('msg_ok');
                        //hide_popup(2000);
                    }
                },
                'json'
            );

        }
    });
    $(body).on('click','.action_recovery',function() {
        var comments_list_block = $('.comments_list');
        var module_name = comments_list_block.data('module');
        var target_id = comments_list_block.data('target_id');

        var comment_id = $(this).data('comment_id');
        var comment_block = $(this).parents('.my_comment');
        $.post(
            "/index.ajax.php",
            {
                area        : 'comments',
                action      : 'recovery_comment',
                comment_id  : comment_id,
                module      : module_name,
                target_id   : target_id
            },
            function(json){
                show_popup();
                $(result_ajax).html(nl2br(json['result_msg']));
                if(json['result']==false) {
                    $(result_ajax).addClass('msg_err');
                    hide_popup(10000);
                } else {
                    comment_block.removeClass('comment_deleted').find('.comment_header').show();
                    comment_block.find('.comment_text').show();
                    comment_block.find('.recovery_block').remove();
                    $(result_ajax).addClass('msg_ok');
                    hide_popup(2000);
                }
            },
            'json'
        );
        return false;
    });

});