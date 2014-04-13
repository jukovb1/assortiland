<?php
/**
 * users_c.groups.php (admin)
 *
 * Контроллер категорий продукции
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


if (isset($_GET['id'])){

    // определяемся показывать или нет вкладки для языков
    if (count($langs_data['by_id'])>1) {
        $show_lang_tabs_for_mod = true;
    }

    $action_for_content = 'edit';
    if ($_GET['id']=='add'){
        $action_for_content = 'add';
        $content_by_id_data['result'] = true;
        $content_by_id_data['result_msg'] = 'add';
        $content_by_id_data['result_data']['us_group_id'] = 'new';
        $content_by_id_data['result_data']['us_group_title'] = false;
        $content_by_id_data['result_data']['us_group_desc'] = false;
        $content_by_id_data['result_data']['us_group_color'] = '';
        $content_by_id_data['result_data']['us_group_prefix'] = '';
        $content_by_id_data['result_data']['us_group_sufix'] = '';

    } else {
        $content_id = intval($_GET['id']);
        $content_by_id_data = adm_users_m::get_users_group_by_id($content_id);
        //ash_debug($content_by_id_data);
    }

    if(!empty($_POST)) {

        $prep_post_data = adm_users_c::group_data_save_prepare($_POST);

        if (!$prep_post_data['result']){
            $msg_color_for_user = 'msg_err';
            $msg_for_user = lang_text($prep_post_data['result_msg']);
            $content_by_id_data['result'] = true;
            $content_by_id_data['result_msg'] = 'error';
            $content_by_id_data['result_data'] = $_POST;
        } else {
            $save_result = adm_users_m::update_users_group($prep_post_data['result_data']);
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



    $content_v = $_SERVER['DOCUMENT_ROOT']."/$adm_folder/modules/$_cur_area/{$_cur_area}_v.groups_edit.php";
} else {
    $content_v = $_SERVER['DOCUMENT_ROOT']."/$adm_folder/modules/$_cur_area/{$_cur_area}_v.groups_list.php";
}



$content_by_group = adm_users_m::get_users_groups();


