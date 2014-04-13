<?php
/**
 * adm_users_c.wait.php (admin)
 *
 * Контроллер работы пользователей ожидающих перехода в группу
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

require_once('adm_users_m.php');
$fields_validation = $user_fields_data['validation'];
$fields_options = $user_fields_data['options'];
$fields_set = $user_fields_data[0];

if (isset($_GET['id'])){
    $multiple_checkbox = new multiple_checkbox();
    $group_arr = adm_users_m::get_users_groups();
    //$group_list_for_user = adm_users_m::get_list_users_group_for_user(intval($_GET['id']));
    //$group_list_for_user = (!empty($group_list_for_user))?$group_list_for_user:array(intval($_GET['id'])=>array());

    $action_for_content = 'edit';
    $user_group_list = adm_users_m::get_users_groups();

    if ($_GET['id']=='add'){
        $action_for_content = 'add';
        $content_by_id_data['result'] = true;
        $content_by_id_data['result_data']['user_id'] = 0;
        $content_by_id_data['result_data']['user_login'] = '';
        $content_by_id_data['result_data']['user_fullname'] = '';
        $content_by_id_data['result_data']['user_default_group'] = 3;
        $content_by_id_data['result_data']['user_email'] =  '';
        $content_by_id_data['result_data']['user_phone'] = '';
        $content_by_id_data['result_data']['user_homepage'] = '';

    } else {
        $content_id = intval($_GET['id']);
        $content_by_id_data = adm_users_m::get_user_data_by_id($content_id);
        if (isset($user_fields_data[$content_by_id_data['result_data']["user_default_group"]])){
            $fields_set = $user_fields_data[$content_by_id_data['result_data']["user_default_group"]];
        }

    }

    if(!empty($_POST)) {
        $post_group_list_for_user = (isset($_POST['user_groups']))?$_POST['user_groups']:array();
        //$group_list_for_user[intval($_GET['id'])] = array_flip($post_group_list_for_user);

        $prep_post_data = adm_users_c::user_data_save_prepare($_POST,$fields_set,$fields_validation);

        if (!$prep_post_data['result']){
            $msg_color_for_user = 'msg_err';
            $msg_for_user = lang_text($prep_post_data['result_msg']);
            $content_by_id_data['result'] = true;
            $content_by_id_data['result_msg'] = 'error';
            $content_by_id_data['result_data'] = $prep_post_data['result_data'];
        } else {
            $save_result = adm_users_m::user_save($prep_post_data['result_data']);
            if ($save_result['result']) {
                $msg_color_for_user = 'msg_ok';
                setcookie('msg_for_user',lang_text($save_result['result_msg']),time()+60,'/');
                $url = parse_url($_SERVER['REQUEST_URI']);
                $new_url = "http://{$_SERVER['HTTP_HOST']}{$url['path']}";
                header("HTTP/1.1 301 Moved Permanently");
                header("Location: $new_url");
            } else{
                $msg_color_for_user = 'msg_err';
            }
            $msg_for_user = lang_text($save_result['result_msg']);
        }
    }

    $content_v = $_SERVER['DOCUMENT_ROOT']."/$adm_folder/modules/$_cur_area/{$_cur_area}_v.user_edit.php";
} else {
    // ash-1 добавить функционал подтверждения или отклонения запроса на вступление в группу
    $content_v = $_SERVER['DOCUMENT_ROOT']."/$adm_folder/modules/$_cur_area/{$_cur_area}_v.users_wait.php";
    $count_items = adm_users_m::count_users_wait();
    $page_nav  = page_navigation::get_page_by_num_for_adm($count_items,'пользователей',$num_of_rows_per_page);
    $content_by_group = adm_users_m::get_users_wait_list($page_nav['nav_start_position'],$page_nav['nav_limit']);
}




