<?php
/**
 * dashbord_c.php (admin)
 *
 * Контроллер главной страницы админки
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
$global_template = array(
    'for_title'      => false,
    'for_title_text' => NULL,
    'for_head'       => NULL,
    'for_content'    => $_SERVER['DOCUMENT_ROOT']."/$adm_folder/modules/$_cur_area/{$_cur_area}_v.php",
);

// создаём список необходимых JS фалов
$js_for_module = array(
    'admin'=>array($_cur_area),
);
$local_js_scripts_list = global_v::print_local_js_in_header($js_for_module);

// записи
require_once($_SERVER['DOCUMENT_ROOT']."/$adm_folder/modules/content/content_m.class.php");
$content_types = content_m::get_content_types();
$current_type = $content_types['content-pages'];
$count_pages = content_m::count_content_by_types($current_type);

// категории и все продукты
require_once($_SERVER['DOCUMENT_ROOT']."/$adm_folder/modules/adm_products/adm_products_m.class.php");
$count_products_groups = adm_products_m::count_products_groups();
$count_products = adm_products_m::count_products();

// пользователи, продавцы и партнеры
require_once($_SERVER['DOCUMENT_ROOT']."/$adm_folder/modules/adm_users/adm_users_m.class.php");
$count_sellers = adm_users_m::count_partners_sellers();
$count_partners = adm_users_m::count_partners_sellers(5);
$count_users = adm_users_m::count_users();

$modul_content = '';