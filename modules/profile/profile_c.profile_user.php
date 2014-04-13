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

require_once('profile_v.functions.php');
$fields_validation = $user_fields_data['validation'];
$fields_options = $user_fields_data['options'];
$fields_set = $user_fields_data[1];

if (!$current_user_profile){
	$fields_set = $user_fields_data['view'][1];
}

if (isset($friendly_url->url_user_data["user_default_group"]) && isset($user_fields_data[$friendly_url->url_user_data["user_default_group"]])){
    $fields_set = $user_fields_data[$friendly_url->url_user_data["user_default_group"]];
	if (!$current_user_profile){
		$fields_set = $user_fields_data['view'][$friendly_url->url_user_data['user_default_group']];
	}
}
// находим группу пользователя
$user_group_data = profile_m::get_users_group_by_id($friendly_url->url_user_data['user_default_group']);
$friendly_url->url_user_data['user_default_group_name'] = $user_group_data['result_data']['us_group_title'][$friendly_url->url_lang['id']];

if(!empty($_POST)) {
	// при вводе Нового пароля
	if(isset($_POST['new_pass']) && isset($_POST['new_pass_confirm'])) {
		$_POST['user_pass'] = $_POST['new_pass'];
		$_POST['user_pass_confirm'] = $_POST['new_pass_confirm'];
		unset($_POST['new_pass'],$_POST['new_pass_confirm']);
	}
    $prep_post_data = profile_c::user_data_save_prepare($_POST,$fields_set,$fields_validation);
    if (!$prep_post_data['result']){
        $msg_color_for_user = 'msg_err';
        $gr = $friendly_url->url_user_data['user_default_group'];
        $msg_for_user = lang_text($prep_post_data['result_msg']);
        $friendly_url->url_user_data = $prep_post_data['result_data'];
        $friendly_url->url_user_data['user_default_group'] = $gr;
    } else {
        $save_result = profile_m::user_save($prep_post_data['result_data']);
        if ($save_result['result']) {
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


if (isset($friendly_url->url_command['edit'])){
    $profile_v_right = $_SERVER['DOCUMENT_ROOT']."/modules/$_cur_area/{$_cur_area}_v.profile_user_edit.php";
} else {
    $profile_v_right = $_SERVER['DOCUMENT_ROOT']."/modules/$_cur_area/{$_cur_area}_v.profile_user_list.php";
}