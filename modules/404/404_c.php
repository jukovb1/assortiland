<?php
/**
 * 404_c.php (admin)
 *
 * Контроллер страницы 404 админки
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
header('HTTP/1.0 404 Not Found');
header('Status: 404 Not Found');

// создаём список необходимых JS файлов
$js_for_module = array(
    'anythingslider','cleditor',
    'dropdown','my'=>array('checkbox','slider'),
);
$local_js_scripts_list = global_v::print_local_js_in_header($js_for_module);

// собираем массив для включения в global_v
$global_template['for_title'] = true;
$global_template['for_title_text'] = lang_text('{error_404}');
$global_template['for_content'] = $_SERVER['DOCUMENT_ROOT']."/modules/404/404_v.php";

$modul_content = '';