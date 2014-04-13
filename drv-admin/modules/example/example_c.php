<?php
/**
 * example_c.php (admin)
 *
 * Контроллер модуля example
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

require_once('example_m.class.php');

// собираем массив для включения в global_v
$global_template = array(
    'for_title'      => false,
    'for_title_text' => NULL,
    'for_head'       => (file_exists($dop_head))?$dop_head:NULL,
    'for_content'    => $_SERVER['DOCUMENT_ROOT']."/$adm_folder/modules/$_cur_area/{$_cur_area}_v.php",
);

// создаём список необходимых JS файлов
$js_for_module = array(
    'admin'=>array($_cur_area),
    'anythingslider','my'=>array('checkbox','slider'),
);
$local_js_scripts_list = global_v::print_local_js_in_header($js_for_module);


// тут код контроллера


// собираем массив для включения в global_v
$global_template = array(
    'for_title'      => true,
    'for_title_text' => 'примкер',
    'for_head'       => (file_exists($dop_head))?$dop_head:NULL,
    'for_content'    => $_SERVER['DOCUMENT_ROOT']."/$adm_folder/modules/$_cur_area/{$_cur_area}_v.php",
);
ash_debug($global_template);
