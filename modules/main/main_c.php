<?php
/**
 * main_c.php (front)
 *
 * Контроллер главной страницы фронта
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
require_once($_SERVER['DOCUMENT_ROOT'].'/modules/catalog/catalog_m.class.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/modules/pages/pages_c.functions.php');
// собираем массив для включения в global_v
$global_template['for_title'] = true;
$global_template['for_title_text'] = lang_text('{module_name}');
$global_template['for_content'] = $_SERVER['DOCUMENT_ROOT']."/modules/$_cur_area/{$_cur_area}_v.php";

// создаём список необходимых JS файлов
$js_for_module = array(
    'anythingslider', 'jcarousel', 'my'=>array('slider'),
    'front'=>array($_cur_area),
);

// данные для акционных предложений внизу главной
$params_for_product_list = catalog_m::get_list_params_by_group(2);
$products_for_actions = catalog_m::get_products_list_special($params_for_product_list,array(),0,6);

$local_js_scripts_list = global_v::print_local_js_in_header($js_for_module);

$global_constants_main_page = global_m::get_constants_data(3);

$clients_arr = global_m::get_contents_array_by_type('clients');

// получаем слайдеры
$page_sliders = get_page_slider_data('main');