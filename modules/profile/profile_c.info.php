<?php
/**
 * profile_c.info.php (front)
 *
 * Контроллер для отображения страниц информации для профиля 
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

$error_info_page = $can_read_info = false;

if(isset($user_data['result_data']) && isset($info_pages[$user_data['result_data']['user_default_group']])) {
	$can_read_info = true;
	
}

if($auth_class->cur_user_group>0 && $can_read_info) {
	$current_info_url = $info_pages[$user_data['result_data']['user_default_group']];
	$info_page_content = global_m::get_content_by_url($current_info_url);
	
	if($info_page_content['result'] == false) {
		$error_info_page = true;
		$info_page_content['result_msg'] = lang_text('{IE_1x105}::{:PAGE_NAME:}='.$current_info_url);
	}
	$profile_v_right = $_SERVER['DOCUMENT_ROOT']."/modules/$_cur_area/{$_cur_area}_v.info.php";
} else {
    $new_url = "http://{$_SERVER['HTTP_HOST']}/profile/auth?ref=".$encode_referer;
    header("HTTP/1.1 301 Moved Permanently");
    header("Location: $new_url");
}
