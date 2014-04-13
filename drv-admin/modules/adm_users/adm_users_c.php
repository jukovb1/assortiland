<?php
/**
 * users_c.php (admin)
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

require_once('adm_users_m.class.php');
require_once('adm_users_c.class.php');
require_once('adm_users_v.functions.php');


// создаём список необходимых JS файлов
$js_for_module = array(
    'redactor',
    'anythingslider','cleditor',
    'migrate',
    'dropdown','my'=>array('checkbox','select'),
    'admin'=>array($_cur_area),
);
$local_js_scripts_list = global_v::print_local_js_in_header($js_for_module);

// указываем тип по-умолчанию
$default_type = 'users-groups'; // список групп
$invalid_index = false;


$content_types['users-groups']  = 'groups';
$content_types['users-rights']  = 'rights';
$content_types['users-list']    = 'list';
$content_types['users-wait']    = 'wait';

// группы пользователей, которые нельзя удалить
$us_group_no_del[1]=true;
$us_group_no_del[2]=true;
$us_group_no_del[3]=true;

if (!is_null($_cur_area_sub)){
    if (isset($content_types[$_cur_area_sub])){
        $current_content_type = $_cur_area_sub;
    } else {
        $current_content_type = $default_type;
        $invalid_index = true;
    }
} else {
    $current_content_type = $default_type;
}

if ($invalid_index){
    $lang_text = global_v::print_lang_text_from_files('404','admin');
    require_once($error_path);
} else {
    $current_type = $content_types[$current_content_type];

    require_once("adm_users_c.$current_type.php");


    $content_v = (isset($content_v))?$content_v:$_SERVER['DOCUMENT_ROOT']."/$adm_folder/modules/$_cur_area/{$_cur_area}_v.$current_type.php";


    // собираем массив для включения в global_v
    $global_template = array(
        'for_title'      => true,
        'for_title_text' => lang_text('{'.$current_type.'}'),
        'for_head'       => (file_exists($dop_head))?$dop_head:NULL,
        'for_content'    => $content_v,
    );
}
