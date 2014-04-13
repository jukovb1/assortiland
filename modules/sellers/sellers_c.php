<?php
/**
 * sellers_c.php (front)
 *
 * Контроллер страницы списка продавцов
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
    'anythingslider', 'jcarousel', 'my'=>array('slider'),
    'front'=>array($_cur_area),
);

$local_js_scripts_list = global_v::print_local_js_in_header($js_for_module);
$global_constants_main_page = global_m::get_constants_data(3);

$clients_arr = global_m::get_contents_array_by_type('clients');

// продавцы
require_once($_SERVER['DOCUMENT_ROOT']."/modules/$_cur_area/sellers_m.class.php");
$count_sellers = global_m::count_partners_sellers();
$page_nav  = page_navigation::get_page_by_num_for_front($count_sellers,$num_of_rows_per_page);
$sellers_list = sellers_m::get_sellers_list($page_nav['nav_start_position'],$page_nav['nav_limit']);