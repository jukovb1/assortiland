<?php
/**
 * comments_c.php
 *
 * Контроллер комментариев
 *
 * Данный файл является частью U.F.O. CMS
 *
 * @author Ashterix <ashterix69@gmail.com>
 * @version 0.0.1
 */
if (!defined('IN_APP')) {
    die("not in app");
}

require_once($_SERVER["DOCUMENT_ROOT"].'/global_scripts/comments/comments.class.php');
$_cur_area = stripslashes($_POST['module']);
$id_for_comments = intval($_POST['target_id']);

$comments_class_ajax = new comments($_cur_area,$id_for_comments,true);

if ($_POST['action']=='add_comment'){

    $add_comment_array['com_module'] = $_cur_area;
    $add_comment_array['com_target_id'] = $id_for_comments;
    $add_comment_array['com_user_id'] = $auth_class->cur_user_id;
    $add_comment_array['com_text'] = strip_tags($_POST['text']);

    $res = $comments_class_ajax->add_comments_for_page($add_comment_array);
    $res['result_msg'] = lang_text($res['result_msg']);
    if ($res['result']){
        $res['result_data'] = $comments_class_ajax->print_comments_block_ajax(3);
    }
    exit(json_encode($res));
}elseif ($_POST['action']=='del_comment' || $_POST['action']=='recovery_comment'){
    $comment_id = intval($_POST['comment_id']);
    $comment_status = ($_POST['action']=='del_comment')?-1:1;
    // проверяем имеет ли право на удаление этот ппользователь
    $comment_data = $comments_class_ajax->get_comment_by_id($comment_id);
    if (($comment_data && $comment_data['com_user_id']==$auth_class->cur_user_id)
        || $auth_class->cur_user_group==1 || $auth_class->cur_user_group==2){
        $res = $comments_class_ajax->comment_change_status($comment_status,$comment_id);
        $res['result_msg'] = lang_text($res['result_msg']);
        if ($res['result']){
            $res['result_data'] = $comments_class_ajax->print_comments_block_ajax(3);
        }
    } else {
        $res['result']=false;
        $res['result_msg']=lang_text("{access_denied}");
    }
    exit(json_encode($res));
}



