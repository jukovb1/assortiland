<?php
/**
 * auth_c.php (front)
 *
 * Контроллер авторизации пользователей для фронта
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

// собираем массив для включения в global_v
$global_template['for_title'] = true;
$global_template['for_title_text'] = lang_text('{module_name}');
$global_template['for_content'] = $_SERVER['DOCUMENT_ROOT']."/modules/$_cur_area/{$_cur_area}_v.php";

// создаём список необходимых JS файлов
$js_for_module = array(
    'anythingslider',
    'my'=>array('checkbox', 'slider', 'select','profile'),
    'front'=>array($_cur_area),
);

$local_js_scripts_list = global_v::print_local_js_in_header($js_for_module);