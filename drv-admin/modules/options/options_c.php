<?php
/**
 * options_c.php (admin)
 *
 * Контроллер страницы парамеры
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

require_once('options_m.class.php');
require_once('options_c.class.php');



// создаём список необходимых JS файлов
$js_for_module = array(
    'redactor',
    'anythingslider','my'=>array('checkbox','slider'),
    'migrate',
    'dropdown',
    'admin'=>array($_cur_area),
);
$local_js_scripts_list = global_v::print_local_js_in_header($js_for_module);

// частные настройки контроллера

// список групп констант
$groups_list = options_m::get_constants_groups();

// указываем группу по-умолчанию
$default_group = 'global'; // Глобальные
$invalid_index = false;


if (!is_null($_cur_area_sub)){
    if (isset($groups_list[$_cur_area_sub])){
        $current_option_group = $_cur_area_sub;
    } else {
        $current_option_group = $default_group;
        $invalid_index = true;
    }
} else {
    $current_option_group = $default_group;
}

$cur_group_id = $groups_list[$current_option_group]['group_id'];


// обработка перед сохранением
if (!empty($_POST)){
    $prep_post_data = options_c::params_save_prepare($_POST);

    if ($prep_post_data['result']){
        $save_result = options_m::update_constants($prep_post_data['result_data']);
        if ($save_result['result']) {
            $msg_color_for_user = 'msg_ok';
        } else{
            $msg_color_for_user = 'msg_err';
        }
        $msg_for_user = lang_text($save_result['result_msg']);
    }
}

// получение списка констант
$constants_by_group = options_m::get_constants_data_for_adm($cur_group_id);

// определяемся показывать или нет вкладки для языков
$show_lang_tabs_for_mod = false;
if (count($langs_data['by_id'])>1) {
    $show_lang_tabs_for_mod = true;
}


// собираем массив для включения в global_v
$global_template = array(
    'for_title'      => false,
    'for_title_text' => NULL,
    'for_head'       => (file_exists($dop_head))?$dop_head:NULL,
    'for_content'    => $_SERVER['DOCUMENT_ROOT']."/$adm_folder/modules/$_cur_area/{$_cur_area}_v.php",
);