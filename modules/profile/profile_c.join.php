<?php
/**
 * profile_c.join.php (front)
 *
 * Контроллер для обработки перехода в группы в профиле
 *
 * Данный файл является частью системы управления контентом
 * разработанной студией Дериво
 *
 * @author Ashterix <ashterix69@gmail.com>
 * @version 0.0.1
 */
if (!defined('IN_APP')) {
    die("not in app");
}

require_once('profile_m.php');
require_once('profile_v.functions.php');

if ($join_to_group){
    $user_group_data = profile_m::get_users_group_by_id($join_group_number);
    $group_name = $user_group_data['result_data']['us_group_title'][$friendly_url->url_lang['id']];
    $fields_set = $user_fields_data[$join_group_number];

    if(!empty($_POST)) {
        $prep_post_data = profile_c::user_data_save_prepare($_POST,$fields_set,$fields_validation);
        if (!$prep_post_data['result']){
            $msg_color_for_user = 'msg_err';
            $gr = $friendly_url->url_user_data['user_default_group'];
            $msg_for_user = lang_text($prep_post_data['result_msg']);
            $friendly_url->url_user_data = $prep_post_data['result_data'];
            $friendly_url->url_user_data['user_default_group'] = $gr;
        } else {
            $prep_post_data['result_data']['user_default_group'] = $join_group_number;
            $prep_post_data['result_data']['user_status_in_group'] = 0;
            $save_result = profile_m::user_save($prep_post_data['result_data']);
            if ($save_result['result']) {
                // тема письма
                $email_join_subject = lang_text("{profile_join_group}::{:GROUP_NAME:}=$group_name");
                $email_variables = "{:USER_NAME:}={$auth_class->cur_user_name}::{:SITE_NAME:}=".get_constant($global_constants,'site_name')."::{:GROUP_NAME:}=$group_name";
                // письмо пользователю
                $email_join_msg = lang_text("{email_msg_for_join_group}::$email_variables");
                global_v::send_msg_to_email($auth_class->cur_user_email,$email_join_subject,$email_join_msg);

                // письмо администратору
                if (get_constant($global_constants,'email_support_join')==1){
                    $email_join_msg = lang_text("{email_for_admin_msg_for_join_group}::$email_variables");
                    global_v::send_msg_to_email(get_constant($global_constants,'email_support'),$email_join_subject,$email_join_msg);
                }

                $msg_color_for_user = 'msg_ok';
                setcookie('msg_for_user',lang_text($save_result['result_msg']),time()+60,'/');
                $url = parse_url($_SERVER['REQUEST_URI']);
                $new_url = "http://{$_SERVER['HTTP_HOST']}/profile";
                header("HTTP/1.1 301 Moved Permanently");
                header("Location: $new_url");
            } else{
                $msg_color_for_user = 'msg_err';
            }
            $msg_for_user = lang_text($save_result['result_msg']);
        }
    }

    $profile_v_right = $_SERVER['DOCUMENT_ROOT']."/modules/$_cur_area/{$_cur_area}_v.join.php";
}