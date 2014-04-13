<?php
/**
 * profile_c.php (front)
 *
 * Контроллер модуля пользователи
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
require_once('profile_m.class.php');
require_once('profile_c.class.php');

$encode_referer = str_replace("?","[Q]",$_SERVER["REQUEST_URI"]);
$encode_referer = str_replace("&","[A]",$encode_referer);
$commercial_const = global_m::get_constants_data(5);

// создаём список необходимых JS файлов
$js_for_module = array(
    'redactor', 'anythingslider','cleditor',
    'migrate','my'=>array('checkbox', 'slider', 'select','profile'),
    'front'=>array($_cur_area),
);
$local_js_scripts_list = global_v::print_local_js_in_header($js_for_module);


// указываем тип по-умолчанию
$profile_v_right = '`Путь не определен`';
$default_type = 'profile_user'; // профиль пользователя по умолчанию
$is_module = $invalid_index = $current_user_profile = false;
if (!is_null($_cur_area_sub) ){
    if (file_exists($_SERVER['DOCUMENT_ROOT']."/modules/$_cur_area/{$_cur_area}_c.{$_cur_area_sub}.php")
    	&& $_cur_area_sub !== $default_type){
        $is_module = true;
    }
} else {
    $is_module = false;
}

if(!empty($auth_class->cur_user_login) && $auth_class->cur_user_group>0) {
    if (count($friendly_url->url_user_data)==0){
        $user_data = profile_m::get_user_data_by_login($auth_class->cur_user_login);
        $friendly_url->url_user_data = $user_data['result_data'];
    }

    if ($auth_class->cur_user_id == $friendly_url->url_user_data['user_id']){
        $current_user_profile = true;
        $subscribed = profile_m::check_subscriber($auth_class->cur_user_id);
        $is_subscribed = $subscribed['result_data'];
    }
} elseif($is_module==false) {

    $new_url = "http://{$_SERVER['HTTP_HOST']}/profile/auth/?ref=".$encode_referer;
    if ($auth_class->cur_user_group>0){
        $new_url = "http://{$_SERVER['HTTP_HOST']}/profile";
    }
    header("HTTP/1.1 301 Moved Permanently");
    header("Location: $new_url");
}

if ($invalid_index){
    $lang_text = global_v::print_lang_text_from_files('404');
    require_once($error_path);
} else {
    $fields_validation = $user_fields_data['validation'];
    $fields_options = $user_fields_data['options'];
    $fields_set = $user_fields_data[1];

    if (!$current_user_profile){
        $fields_set = $user_fields_data['view'][1];
    }

    // QR код генератор
    $show_qr = false;
    $qr_img = NULL;
    if (!empty($friendly_url->url_user_data) 
    	&& ($friendly_url->url_user_data['user_default_group']==4 || $friendly_url->url_user_data['user_default_group']==5)){
        $show_qr = true;
        require_once($_SERVER['DOCUMENT_ROOT'].'/global_scripts/phpqrcode/qrlib.php');
        if ($friendly_url->url_user_data['user_default_group']==4){
            $link_for_qr = "http://{$_SERVER['SERVER_NAME']}/catalog/marketplace={$friendly_url->url_user_data['user_login']}";
        } elseif ($friendly_url->url_user_data['user_default_group']==5) {
            $link_for_qr = "http://{$_SERVER['SERVER_NAME']}/catalog/marketplace_p={$friendly_url->url_user_data['user_login']}";
        } else {
            $link_for_qr = "http://{$_SERVER['SERVER_NAME']}/profile/{$friendly_url->url_user_data['user_login']}";
        }
        QRcode::png($link_for_qr,$_SERVER['DOCUMENT_ROOT']."/adm_dop_files/qr_codes/qr_{$friendly_url->url_user_data['user_login']}.png",QR_ECLEVEL_L,4,0);
        $qr_img = "<img src='/adm_dop_files/qr_codes/qr_{$friendly_url->url_user_data['user_login']}.png' />";
    }

    if (isset($user_fields_data[$auth_class->cur_user_group])){
        $fields_set = $user_fields_data[$auth_class->cur_user_group];
    }

    $current_profile_left_menu = $left_menu_fields_data[0]; // все

    if($auth_class->cur_user_group==3 || $auth_class->cur_user_group==5) {
        // обработка заявки на переход в группу
        if (isset($friendly_url->url_command['join'])){
            if (isset($cur_join_group[intval($friendly_url->url_command['join'])])){
                $join_group_number = intval($friendly_url->url_command['join']);
                $join_to_group = $cur_join_group[$join_group_number];
                $is_module = true;
                $_cur_area_sub = 'join';
            }
        }
    }

    // информация в меню пользователя
    $current_profile_left_menu = $left_menu_fields_data[1];
    if(isset($left_menu_fields_data[$auth_class->cur_user_group])) {
        $current_profile_left_menu = $left_menu_fields_data[$auth_class->cur_user_group];
    }

    if($is_module){
		require_once($_SERVER['DOCUMENT_ROOT']."/modules/$_cur_area/{$_cur_area}_c.{$_cur_area_sub}.php");
	} else {
		// логика для получения данных юзера
		require_once($_SERVER['DOCUMENT_ROOT']."/modules/$_cur_area/{$_cur_area}_c.{$default_type}.php");
	}
	
    $content_v = (isset($content_v))?$content_v:$_SERVER['DOCUMENT_ROOT']."/modules/$_cur_area/{$_cur_area}_v.php";


    // собираем массив для включения в global_v
	$global_template['for_title'] = true;
	$global_template['for_title_text'] = lang_text('{'.$_cur_area.'}');
	$global_template['for_head'] = (file_exists($dop_head))?$dop_head:NULL;
	$global_template['for_meta_keys'] = ''; // get_constant($catalog_constants,'catalog_seo_keywords');
	$global_template['for_meta_desc'] = ''; // get_constant($catalog_constants,'catalog_seo_desc');
	$global_template['for_content'] = $content_v;
	$global_template['for_noindex'] = true;
}
