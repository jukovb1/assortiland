<?php
/**
 * main_menu_c.php
 *
 * Контроллер главного меню фронта
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

require_once('main_menu_m.php');
require_once('main_menu_v.functions.php');
require_once('main_menu_c.functions.php');
// главное меню
$site_main_menu = array();
$main_menu = global_m::get_constants_data(7);
if(isset($main_menu)) {
    $main_menu = explode(',', $main_menu['site_main_menu']);

    foreach ($main_menu as $menu) {
        $menu = explode('|', $menu);
        $site_main_menu[$menu[0]] = $menu[1];
    }
}
